<?php
return array( // 添加下面一行定义即可
    'app_init' => array(
        'Common\Behavior\InitHookBehavior',
    ),
    'app_begin' => array(
        'Behavior\CheckLangBehavior',
        'Common\Behavior\UrldecodeGetBehavior'
    ),
	'action_begin' =>array(
		'Common\Behavior\CustomActionBeginBehavior',
	),
	'return_success' =>array(
		'Common\Behavior\CustomSuccessBehavior',
	),
    'view_filter' => array(
        'Common\Behavior\TmplStripSpaceBehavior'
    ),
    'admin_begin' => array(
        'Common\Behavior\AdminDefaultLangBehavior'
    )
)
;