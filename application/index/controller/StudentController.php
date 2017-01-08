<?php
namespace app\index\controller;

use think\Request;
use app\common\model\Student;
use app\common\model\Teacher;
use app\common\model\Klass;

class StudentController extends IndexController
{
	/**
	 * index数据列表
	 * @return [type] [description]
	 */
	public function index()
	{
		// 获取查询信息
		$name = Request::instance()->get('name');

		$pageSize = 5;//每页显示条数

		$Student = new Student();
		$students = $Student->pagiN($pageSize, $name);

		$this->assign('students', $students);

		return $this->fetch();
	}

	/**
	 * 增加数据页面
	 */
	public function add()
	{
		$klasses = Klass::all();
		$this->assign('klasses', $klasses);
		return $this->fetch();
	}

	/**
	 * 插入新数据
	 * @return 成功返回插入数据的条数，失败返回false
	 */
	public function save()
	{
		$Student = new Student;
		$Request = Request::instance();

		$Student->name = $Request->post('name');
		$Student->num = $Request->post('num');
		$Student->sex = $Request->post('sex');
		$Student->klass_id = $Request->post('klass_id');
		$Student->email = $Request->post('email');

		if(!$Student->validate(true)->save()){
			return $this->error('添加错误：'.$Student->getError());
		}

		return $this->success('添加成功！', url('index'));
	}

	/**
	 * 编辑数据
	 * @return [type] [description]
	 */
	public function edit()
    {
        $id = Request::instance()->param('id/d');

        // 判断是否存在当前记录
        if (is_null($Student = Student::get($id))) {
            return $this->error('未找到ID为' . $id . '的记录');
        }

        // 取出班级列表(此步骤用getKlass方法代替)
        // $klasses = Klass::all();
        // $this->assign('klasses', $klasses);

        $this->assign('Student', $Student);
        return $this->fetch();
    }

    /**
	 * 更新数据
	 * @return [type] [description]
	 */
	public function update()
	{
		// 接收数据，取要更新的关键字信息
		$id = Request::instance()->post('id/d');

		// 获取当前对象
        $klass = Klass::get($id);

        if(is_null($klass)){
        	return $this->error('所更新的记录不存在');
        }

        //数据更新
        $klass->name = Request::instance()->post('name');
        $klass->teacher_id = Request::instance()->post('teacher_id');
        if(!$klass->validate(true)->save()){
        	return $this->error('更新错误：' . $klass->getError());
        }else{
        	return $this->success('操作成功', url('index'));
        }
	}

	/**
	 * 删除数据
	 * @return [type] [description]
	 */
	public function delete()
	{
		// 接收数据，取要删除的关键字信息
		$Request = Request::instance();
		$id = $Request->param('id/d');

		// 获取当前对象
        $klass = Klass::get($id);

        if(0 === $id || is_null($klass)){
        	return $this->error('删除的记录不存在');
        }

        //删除对象
        if(!$klass->delete()){
        	return $this->error('删除失败:' . $klass->getError());
        }

        // 进行跳转 
        return $this->success('删除成功', $Request->header('referer')); 
	}
}
