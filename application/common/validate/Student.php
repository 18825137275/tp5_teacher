<?php
namespace app\common\validate;

use think\Validate;

class Student extends Validate
{
	protected $rule = [
		'name' => 'require|length:2,6',
		'num' => 'require|integer',
		'sex' => 'require|in:0,1',
		'klass_id' => 'require|number',
		'email' => 'email',
	];
}
