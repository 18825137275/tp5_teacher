<?php
namespace app\common\model;

use think\Model;
/**
 * Student 学生表
 */
class Student extends Model
{
	/**
     * 自定义自转换字段类型
     * @var array
     */
	// protected $type = [
 //        'create_time' => 'datetime',
 //    ];

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
     * 获取器：获取性别
     * @return string 0男，1女
     * @author 梦云智 http://www.mengyunzhi.com
     */
    public function getSexAttr($value)
    {
        $status = array('0'=>'男','1'=>'女');
        $sex = $status[$value];
        if (isset($sex))
        {
            return $sex;
        } else {
            return $status[0];
        }
    }

    /**
     * 获取器：获取要显示的创建时间
     * @param  int $value 时间戳
     * @return string  转换后的字符串
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getCreateTimeAttr($value)
    {
    	return date('Y-m-d H:i:s', $value);
    }

    /**
     * 获取对应的班级信息（多对一关联belongsTo）
     * @return Klass 班级
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getKlass()
    {
    	return $this->belongsTo('Klass');
    }

    /**
     * 获取对应的教师信息（多对一关联belongsTo）
     * @return Teacher 教师
     * @author panjie <panjie@yunzhiclub.com>
     */
    public function getTeacher()
    {
    	return $this->belongsTo('Teacher');
    }
}


