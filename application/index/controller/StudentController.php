<?php
namespace app\index\controller;

use think\Request;
use app\common\model\Student;
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
		//获取所有的班级信息
		// $klasses = Klass::all();
		// $this->assign('klasses', $klasses);

		//传入一个空的Student，用以V层通一对多关联的getKlass()方法获取班级信息，而不必传入班级列表（Klass）信息和use Klass模型了。
		$Student = new Student;

		//重构代码，传入一个空的模型，跟edit共用一个模板edit.html
		$Student->id = 0;
		$Student->name = '';
		$Student->num = '';
		$Student->sex = 0;
		$Student->klass_id = 0;
		$Student->email = '';

		$this->assign('Student', $Student);
		//调用edit.html模板
		return $this->fetch('edit');
	}

	/**
     * 对数据进行更新或保存
     * @说明：这里把function设置为private私有属性，一是为了更加安全，因为声明为private后，就不能通过URL来进行访问了；二是为了区别触发器与一般的函数，我们触发器是可以被URL来触发，而一般的函数只所以不叫做触发器，是由于通过URL触发不到。我们声明为private就达到了这个触发不到的目的。
     * @param  Student &$Student 注意：我们在这的参数为(&$Student)，这使得：如果执行$Student->validate(true)->save()时发生错误，错误信息能够能过Student变量进行回传，这和C语言中的&a(将变量a的地址传入)是相同的道理。
     * @param  boolean $isUpdate 判断是否为更新操作，如果是更新某些不能修改的数据则不被提交
     * @return [type]            [description]
     */
	private function saveStudent(Student &$Student, $isUpdate = false)
	{
		$Request = Request::instance();

		$Student->name = $Request->post('name');
		//如果为更新操作，学号不能修改
		if(!$isUpdate){
			$Student->num = $Request->post('num');
		}
		$Student->sex = $Request->post('sex');
		$Student->klass_id = $Request->post('klass_id');
		$Student->email = $Request->post('email');

		return $Student->validate(true)->save();
	}

	/**
	 * 插入新数据
	 * @return 成功返回插入数据的条数，失败返回false
	 */
	public function save()
	{
		$Student = new Student;

		if(!$this->saveStudent($Student)){
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
        $Student = Student::get($id);

        if(is_null($Student)){
        	return $this->error('所更新的记录不存在');
        }

        if(!$this->saveStudent($Student, true)){
        	return $this->error('更新错误：' . $Student->getError());
        }
        	
    	return $this->success('操作成功', url('index'));
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
        $student = Student::get($id);

        if(0 === $id || is_null($student)){
        	return $this->error('删除的记录不存在');
        }

        //删除对象
        if(!$student->delete()){
        	return $this->error('删除失败:' . $student->getError());
        }

        // 进行跳转 
        return $this->success('删除成功', $Request->header('referer')); 
	}
}
