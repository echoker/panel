{{-- Copyright (c) 2015 - 2016 Dane Everitt <dane@daneeveritt.com> --}}

{{-- Permission is hereby granted, free of charge, to any person obtaining a copy --}}
{{-- of this software and associated documentation files (the "Software"), to deal --}}
{{-- in the Software without restriction, including without limitation the rights --}}
{{-- to use, copy, modify, merge, publish, distribute, sublicense, and/or sell --}}
{{-- copies of the Software, and to permit persons to whom the Software is --}}
{{-- furnished to do so, subject to the following conditions: --}}

{{-- The above copyright notice and this permission notice shall be included in all --}}
{{-- copies or substantial portions of the Software. --}}

{{-- THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR --}}
{{-- IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, --}}
{{-- FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE --}}
{{-- AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER --}}
{{-- LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, --}}
{{-- OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE --}}
{{-- SOFTWARE. --}}
@extends('layouts.master')

@section('title')
    {{ trans('base.index.header') }}
@endsection

@section('content-header')
    <h1>{{ trans('base.index.header') }}<small>{{ trans('base.index.header_sub')}}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('index') }}">{{ trans('strings.home') }}</a></li>
        <li class="active">{{ trans('strings.servers') }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('base.index.list') }}</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="{{ trans('strings.search') }}">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>{{ trans('strings.id') }}</th>
                            <th>{{ trans('strings.name') }}</th>
                            <th>{{ trans('strings.node') }}</th>
                            <th>{{ trans('strings.connection') }}</th>
                            <th class="text-center hidden-sm hidden-xs">{{ trans('strings.memory') }}</th>
                            <th class="text-center hidden-sm hidden-xs">{{ trans('strings.cpu') }}</th>
                            <th class="text-center">{{ trans('strings.status') }}</th>
                        </tr>
                        @foreach($servers as $server)
                        <tr class="dynamic-update" data-server="{{ $server->uuidShort }}">
                            <td><code>{{ $server->uuidShort }}</code></td>
                            <td><a href="/server/{{ $server->uuidShort }}">{{ $server->name }}</a></td>
                            <td>{{ $server->nodeName }}</td>
                            <td><code>@if(!is_null($server->ip_alias)){{ $server->ip_alias }}@else{{ $server->ip }}@endif:{{ $server->port }}</code></td>
                            <td class="text-center hidden-sm hidden-xs"><span data-action="memory">--</span> / {{ $server->memory === 0 ? '&infin;' : $server->memory }} MB</td>
                            <td class="text-center hidden-sm hidden-xs"><span data-action="cpu" data-cpumax="{{ $server->cpu }}">--</span> %</td>
                            <td class="text-center" data-action="status">
                                @if($server->suspended === 1)
                                    <span class="label label-warning">{{ trans('strings.suspended') }}</span>
                                @else
                                    <span class="label label-default"><i class="fa fa-refresh fa-fw fa-spin"></i></span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('js/frontend/serverlist.js') !!}
@endsection
