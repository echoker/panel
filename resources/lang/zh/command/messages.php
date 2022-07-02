<?php

return [
    'location' => [
        'no_location_found' => '找不到与提供的标识码匹配的记录。',
        'ask_short' => '地域标识码',
        'ask_long' => '地域描述',
        'created' => '已成功创建 ID 为 :id 的新地域 (:name)。',
        'deleted' => '已成功删除请求的地域。',
    ],
    'user' => [
        'search_users' => '输入用户名、用户 ID 或邮箱地址',
        'select_search_user' => '要删除的用户ID (输入\'0\'重新搜索)',
        'deleted' => '已成功将该用户从面板中删除。',
        'confirm_delete' => '您确定要从面板中删除此用户吗？',
        'no_users_found' => '提供的搜索词未能找到相符的用户。',
        'multiple_found' => '提供的搜索词找到多个帐户，由于 --no-interaction 标签而无法删除用户。',
        'ask_admin' => '此用户是否为管理员？',
        'ask_email' => '邮箱地址',
        'ask_username' => '用户名',
        'ask_name_first' => '名字',
        'ask_name_last' => '姓氏',
        'ask_password' => '密码',
        'ask_password_tip' => '如果您想使用通过电子邮件发送给用户的随机密码创建一个帐户，请重新运行此命令 (CTRL+C) 并传递 `--no-password` 标签。',
        'ask_password_help' => '密码长度必须至少为 8 个字符，并且至少包含一个大写字母和数字。',
        '2fa_help_text' => [
            '如果启用，此命令将禁用用户帐户的双因素认证。仅当用户被锁定在其帐户之外时，才应将其用作帐户恢复命令。',
            '如果这不是您想要执行的操作，请按 CTRL+C 退出此过程。',
        ],
        '2fa_disabled' => '已为 :email 禁用双因素认证。',
    ],
    'schedule' => [
        'output_line' => '为 `:schedule` (:hash) 中的第一个任务分配作业。',
    ],
    'maintenance' => [
        'deleting_service_backup' => '删除服务备份文件 :file。',
    ],
    'server' => [
        'rebuild_failed' => '在节点 ":node" 上对 ":name" (#:id) 的重建请求失败并出现错误：:message',
        'reinstall' => [
            'failed' => '在节点 ":node" 上重新安装 ":name" (#:id) 请求失败并出现错误: :message',
            'confirm' => '您即将针对一组服务器重新安装。你想继续吗？',
        ],
        'power' => [
            'confirm' => '您即将对 :count 服务器执行 :action。你想继续吗？',
            'action_failed' => '节点 ":node" 上 ":name" (#:id) 的电源操作请求失败并出现错误: :message',
        ],
    ],
    'environment' => [
        'mail' => [
            'ask_smtp_host' => 'SMTP 主机 (例如 smtp.gmail.com)',
            'ask_smtp_port' => 'SMTP 端口',
            'ask_smtp_username' => 'SMTP 用户名',
            'ask_smtp_password' => 'SMTP 密码',
            'ask_mailgun_domain' => 'Mailgun Domain',
            'ask_mailgun_endpoint' => 'Mailgun Endpoint',
            'ask_mailgun_secret' => 'Mailgun Secret',
            'ask_mandrill_secret' => 'Mandrill Secret',
            'ask_postmark_username' => 'Postmark API Key',
            'ask_driver' => 'Which driver should be used for sending emails?',
            'ask_mail_from' => 'Email address emails should originate from',
            'ask_mail_name' => '显示的邮箱名称',
            'ask_encryption' => '加密方式',
        ],
    ],
];
