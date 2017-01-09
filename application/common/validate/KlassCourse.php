<?php
namespace app\common\validate;

use think\Model;

class KlassCourse extends Model
{
	protected $rule = [
		'klass_id' => 'require',
		'course_id' => 'require'
	];
}