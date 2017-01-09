<?php
namespace app\index\controller;

use think\Request;	//
use app\common\model\Course;	//课程MODEL
// use app\common\model\KlassCourse;
/**
 * 课程管理
 */
class CourseController extends IndexController
{
	/**
	 * index数据列表
	 * @return [type] [description]
	 */
	public function index()
	{
		// 获取查询信息
		$name = Request::instance()->param('name');
		$pageSize = 5;//每页显示条数

		$Course = new Course();

		$Courses = $Course->pagiN($pageSize, $name);

		$this->assign('Courses', $Courses);
		return $this->fetch();
	}

	/**
	 * 增加数据页面
	 */
	public function add()
	{
		//获取所有的班级信息
		// $klasses = Klass::all();
		// $this->assign('klasses', $klasses);
		
		//传入一个空的Course，用以V层通多对多关联的klasses()方法获取班级信息，而不必传入班级列表（Klass）信息和use Klass模型了。
		$this->assign('Course', new Course);

		return $this->fetch();
	}

	/**
	 * 插入新数据
	 * @return [type] [description]
	 */
	public function save()
	{
		//存课程信息
		$Course = new Course();
		$Course->name = Request::instance()->post('name');

		//新增数据并验证
		if(!$Course->validate(true)->save()){
			return $this->error('保存错误：' . $Course->getError());
		}

		// -------------------------- 新增班级课程信息 -------------------------- 
        // 接收klass_id这个数组
        $klassIds = Request::instance()->post('klass_id/a');// /a表示获取的类型为数组
        
        //利用klass_id这个数组，拼接为包括klass_id和course_id的二维数组
        if(!is_null($klassIds)){
        	if(!$Course->getKlasses()->saveAll($klassIds)){
        		return $this->error('课程-班级信息保存错误：' . $Course->getKlasses()->getError());
        	}
        }
        // -------------------------- 新增班级课程信息(end) -------------------------- 

        unset($Course); // unset出现的位置和new语句的缩进量相同，在返回前，最后被执行。
		return $this->success('操作成功！', url('index'));
	}

	/**
	 * 编辑数据
	 * @return [type] [description]
	 */
	public function edit()
	{
		$id = Request::instance()->param('id/d');

		$Course = Course::get($id);

		if(is_null($Course)){
			return $this->error('不存在ID为' . $id . '的记录');
		}
		$this->assign('Course', $Course);
		return $this->fetch();
	}

	/**
	 * 更新数据
	 * @return [type] [description]
	 */
	public function update()
	{
		//获取当前课程
		$id = Request::instance()->post('id/d');
		if(is_null($Course = Course::get($id))){
			return $this->error('不存在id为：' . $id . '的记录');
		}

		//更新课程名
		$Course->name = Request::instance()->post('name');
		if(is_null($Course->validate(true)->save())){
			return $this->error('课程信息更新发生错误：' . $Course->getError());
		}

		//删除原有信息
		$map = ['course_id' => $id];

		// 执行删除操作。由于可能存在 成功删除0条记录，故使用false来进行判断，而不能使用
        // if (!KlassCourse::where($map)->delete()) {
        // 我们认为，删除0条记录，也是成功
        if(false === $Course->getKlassCourses()->where($map)->delete()){
        	return $this->error('删除班级课程关联信息发生错误' . $Course->getKlassCourses()->getError());
        }

        //增加新增数据，执行添加操作
        $klassIds = Request::instance()->post('klass_id/a');
        if(!is_null($klassIds)){
        	if(!$Course->getKlasses()->saveAll($klassIds)){
        		return $this->error('课程-班级信息保存错误：' . $Course->Klasses()->getError());
        	}
        }
        return $this->success('更新成功！', url('index'));
	}

	/**
	 * 删除数据
	 * @return [type] [description]
	 */
	public function delete()
	{
		$id = Request::instance()->param('id/d');

		$Course = Course::get($id);

		//删除课程信息
		if(0 === $id || is_null($Course)){
			return $this->error('删除的记录不存在');
		}

		if(!$Course->delete()){
			return $this->error('删除失败:' . $Course->getError());
        }

        //删除班级课程信息
        $map = ['course_id' => $id];

        // 执行删除操作。由于可能存在 成功删除0条记录，故使用false来进行判断，而不能使用
        // if (!KlassCourse::where($map)->delete()) {
        // 我们认为，删除0条记录，也是成功
        if(false === $Course->getKlassCourses()->where($map)->delete()){
        	return $this->error('删除班级课程关联信息发生错误' . $Course->getKlassCourses()->getError());
        }

        // 进行跳转 
        return $this->success('删除成功', url('index'));
	}
}