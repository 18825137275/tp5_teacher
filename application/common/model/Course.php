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

	/**
	 * 获取是否存在相关关联记录（edit页面，班级信息默认勾选）
	 * @param  [type] $klass [description]
	 * @return [type]        [description]
	 */
	public function getIsChecked(Klass &$klass)
	{
		//取课程ID
		$courseId = (int)$this->id;
		$klassId = (int)$klass->id;

		$map = array();
		$map['klass_id'] = $klassId;
		$map['course_id'] = $courseId;

		$klassCourse = KlassCourse::get($map);

		if (is_null($klassCourse)) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * 一对多关联（hasMany）
	 * @return [type] [description]
	 */
	public function getKlassCourses()
	{
		return $this->hasMany('KlassCourse');
	}
}