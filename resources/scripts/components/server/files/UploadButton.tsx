import { CloudUploadIcon } from '@heroicons/react/outline';
import { useSignal } from '@preact/signals-react';
import axios from 'axios';
import { useEffect, useRef } from 'react';
import tw from 'twin.macro';

import getFileUploadUrl from '@/api/server/files/getFileUploadUrl';
import { Button } from '@/components/elements/button/index';
import { ModalMask } from '@/components/elements/Modal';
import Portal from '@/components/elements/Portal';
import FadeTransition from '@/components/elements/transitions/FadeTransition';
import type { WithClassname } from '@/components/types';
import useEventListener from '@/plugins/useEventListener';
import { useFlashKey } from '@/plugins/useFlash';
import useFileManagerSwr from '@/plugins/useFileManagerSwr';
import { ServerContext } from '@/state/server';

function isFileOrDirectory(event: DragEvent): boolean {
    if (!event.dataTransfer?.types) {
        return false;
    }

    return event.dataTransfer.types.some(value => value.toLowerCase() === 'files');
}

export default ({ className }: WithClassname) => {
    const fileUploadInput = useRef<HTMLInputElement>(null);

    const visible = useSignal(false);
    const timeouts = useSignal<NodeJS.Timeout[]>([]);

    const { mutate } = useFileManagerSwr();
    const { addError, clearAndAddHttpError } = useFlashKey('files');

    const uuid = ServerContext.useStoreState(state => state.server.data!.uuid);
    const directory = ServerContext.useStoreState(state => state.files.directory);
    const { clearFileUploads, removeFileUpload, pushFileUpload, setUploadProgress } = ServerContext.useStoreActions(
        actions => actions.files,
    );

    useEventListener(
        'dragenter',
        e => {
            e.preventDefault();
            e.stopPropagation();
            if (isFileOrDirectory(e)) {
                visible.value = true;
            }
        },
        { capture: true },
    );

    useEventListener('dragexit', () => (visible.value = false), { capture: true });

    useEventListener('keydown', () => (visible.value = false));

    useEffect(() => {
        return () => timeouts.value.forEach(clearTimeout);
    }, []);

    const onUploadProgress = (data: ProgressEvent, name: string) => {
        setUploadProgress({ name, loaded: data.loaded });
        if (data.loaded >= data.total) {
            timeouts.value.push(setTimeout(() => removeFileUpload(name), 500));
        }
    };

    const onFileSubmission = (files: FileList) => {
        clearAndAddHttpError();
        const list = Array.from(files);
        if (list.some(file => !file.size || (!file.type && file.size === 4096))) {
            return addError('目前不支持文件夹上传。', '错误');
        }

        const uploads = list.map(file => {
            const controller = new AbortController();
            pushFileUpload({ name: file.name, data: { abort: controller, loaded: 0, total: file.size } });

            return () =>
                getFileUploadUrl(uuid).then(url =>
                    axios.post(
                        url,
                        { files: file },
                        {
                            signal: controller.signal,
                            headers: { 'Content-Type': 'multipart/form-data' },
                            params: { directory },
                            onUploadProgress: data => onUploadProgress(data, file.name),
                        },
                    ),
                );
        });

        Promise.all(uploads.map(fn => fn()))
            .then(() => mutate())
            .catch(error => {
                clearFileUploads();
                clearAndAddHttpError(error);
            });
    };

    return (
        <>
            <Portal>
                <FadeTransition show={visible.value} duration="duration-75" key="upload_modal_mask" appear unmount>
                    <ModalMask
                        onClick={() => (visible.value = false)}
                        onDragOver={e => e.preventDefault()}
                        onDrop={e => {
                            e.preventDefault();
                            e.stopPropagation();

                            visible.value = false;
                            if (!e.dataTransfer?.files.length) {
                                return;
                            }

                            onFileSubmission(e.dataTransfer.files);
                        }}
                    >
                        <div className={'w-full flex items-center justify-center pointer-events-none'}>
                            <div
                                className={
                                    'flex items-center space-x-4 bg-black w-full ring-4 ring-blue-200 ring-opacity-60 rounded p-6 mx-10 max-w-sm'
                                }
                            >
                                <CloudUploadIcon className={'w-10 h-10 flex-shrink-0'} />
                                <p className={'font-header flex-1 text-lg text-neutral-100 text-center'}>
                                    拖放文件以上传。
                                </p>
                            </div>
                        </div>
                    </ModalMask>
                </FadeTransition>
            </Portal>
            <input
                type={'file'}
                ref={fileUploadInput}
                css={tw`hidden`}
                onChange={e => {
                    if (!e.currentTarget.files) return;

                    onFileSubmission(e.currentTarget.files);
                    if (fileUploadInput.current) {
                        fileUploadInput.current.files = null;
                    }
                }}
                multiple
            />
            <Button className={className} onClick={() => fileUploadInput.current && fileUploadInput.current.click()}>
                上传
            </Button>
        </>
    );
};
