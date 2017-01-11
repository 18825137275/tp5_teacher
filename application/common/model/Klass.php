<?php
namespace app\common\model;

use think\Model;
/**
 * Klass 班级表
 */
class Klass extends Model
{
	//分页+查询参数
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
     * 获取对应的教师（辅导员）信息
     * @return Teacher 教师
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getTeacher()
    {
    	return $this->belongsTo('Teacher');
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

