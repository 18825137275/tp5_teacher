<?php
namespace app\common\model;

use think\Model;
/**
 * Course 课程表
 */
class Course extends Model
{
	/**
	 * 分页+查询参数
	 * @param  [type] $pageSize [description]
	 * @param  [type] $name     [description]
	 * @return [type]           [description]
	 */
	public function pagiN($pageSize, $name)
	{
		if(!empty($name)){
			$this->where('name', 'like', '%'.$name.'%');
		}

		return $this->paginate($pageSize, false, [
			'query' => [
				'name' => $name,
				],
			]);
	}

	/**
	 * 多对多关联：关联班级表信息
	 * @return [type] [description]
	 */
	public function getKlasses()
	{
		return $this->belongsToMany('Klass', config('database.prefix') . 'klass_course');
	}
}