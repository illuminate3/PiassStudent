<?php namespace App\Http\Controllers;

use Input,Excel,Flash;
use App\Http\Requests;
use App\Models\Student;
use App\Models\Faculity;
use App\Models\Department;
use App\Models\Module;
use App\Models\Reports;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ReportStudentController extends Controller {

	private $student;
	private $faculity;
	private $department;
	private $module;
	private $reports;

	function __construct(Student $student,Faculity $faculity,Department $department,Module $module,Reports $reports) 
	{
		parent::__construct();

		$this->student 		= 	$student;
		$this->faculity 	=	$faculity;
		$this->department 	= 	$department;
		$this->module 		= 	$module;
		$this->reports 		= 	$reports;
	}

	/**
	 * Get student details in a report
	 * 
	 * @return mixed
	 */
	
	public function details()
	{	
		// First check if the user has the permission to do this
		if (!$this->user->hasAccess('report.student.details')) 
		{			
			 Flash::error(trans('Sentinel::users.noaccess'));
             
             return redirect()->back();
		}

		// Get information
		$students 	= $this->studentDetails();

	    $students = $this->getStudentPaymentsArray($students);
		
		// Do we have to export the results ?
		Input::get('export')?$this->export('students_details',$students) : null ;

		//Get html table
		$table 		= $this->htmlTable($students);
	
		$header 	= '<i class="fa fa-graduation-cap"></i> <span>Students detailed report</span>';

		return view('reports.students.details',compact('table','header'));
		
	}

	/**
	 * Student payment progress
	 * 
	 * @return mixed
	 */
	public function paymentProgression()
	{
		// First check if the user has the permission to do this
		if (!$this->user->hasAccess('report.student.payment.progress')) 
		{			
			 Flash::error(trans('Sentinel::users.noaccess'));
             
             return redirect()->back();
		}
		
		// Get information
		$students 	= $this->studentDetails();

		// Do we have to export the results ?
		Input::get('export')?$this->export('students_with_payment_details',$students) : null ;

		//Swap the keys to match the report fields
		$students 	= $this->getStudentPaymentsArray($students);

		$header 	= '<i class="fa fa-credit-card"></i> <span>Students payements progress </span>';

		//Get html table
		$table 		= $this->htmlTable($students);

		return view('reports.students.details',compact('table','header'));
		
	}


	/**
	 * Student with full paid school fees progress
	 * 
	 * @return mixed
	 */
	public function fullPaid()
	{
		// First check if the user has the permission to do this
		if (!$this->user->hasAccess('report.student.payment.paid')) 
		{			
			 Flash::error(trans('Sentinel::users.noaccess'));
             
             return redirect()->back();
		}

		// Get information by passing true so that we get thos who paid
		$students 	= $this->studentDetails(true);

		// Do we have to export the results ?
		Input::get('export')?$this->export('full_paid_students',$students) : null ;

		//Swap the keys to match the report fields
		$students 	= $this->getStudentPaymentsArray($students);

		$header 	= '<i class="fa fa-usd"></i><i class="fa fa-graduation-cap"></i> <span>Students who paid all fees </span>';
		//Get html table
		$table 		= $this->htmlTable($students);

		return view('reports.students.details',compact('table','header'));
	}

	/**
	 * Student with full paid school fees progress
	 * 
	 * @return mixed
	 */
	public function pendingPayment()
	{
		// First check if the user has the permission to do this
		if (!$this->user->hasAccess('report.student.payment.panding')) 
		{			
			 Flash::error(trans('Sentinel::users.noaccess'));
             
             return redirect()->back();
		}

		
		// Get information by passing true so that we get thos who paid
		$students 	= $this->studentDetails(false);

		// Do we have to export the results ?
		Input::get('export')?$this->export('students_with_pending_fees',$students) : null ;

		//Swap the keys to match the report fields
		$students 	= $this->getStudentPaymentsArray($students);
		
		$header 	= '<i class="fa fa-usd"></i><i class="fa fa-graduation-cap"></i> <span>Students who has pending fees </span>';
		
		//Get html table
		$table 		= $this->htmlTable($students);

		return view('reports.students.details',compact('table','header'));;
		
	}
	/**
	 * Export to excel
	 * @param  [type]
	 * @param  [type]
	 * @return [type]
	 */
	private function export($name,$data)
	{
		
	 Excel::create($name, function($excel) use($data)
	  {
         $excel->sheet('Students', function($sheet) use($data) 
         {

        	$sheet->fromArray($data);

    	  });

     })->export('xlsx');
	
	}

	/**
	 * This method will help us to get all student related information from V_STUDENTS_REPORT VIEW
	 */ 
	private function studentDetails($status=null)
	{

		$faculity 		= !Input::get('faculity')? false :	$this->faculity->findOrFail(Input::get('faculity'))->name;	
		$department 	= !Input::get('department')? false:	$this->department->findOrFail(Input::get('department'))->name;
		$level 			= (int) Input::get('level');
		$module 		= !Input::get('module')?	false :	$this->module->findOrFail(Input::get('module'))->name;

	  return	$students = $this->reports->studentDetails($faculity,$department,$level,$module,$status)->get()->toArray();
		
	}

	/**
	 * Generate HTML table
	 */
	private function htmlTable($students)
	{
	    // Try to get arrays headers
     	 $headers = array_keys($students);
	    //if it is multidimensions get sub array keys
	    
	    if (isset($students[0]))
	    {
	    	$headers = array_keys($students[0]) ;
	    }

		$table = new \App\Helpers\HtmlTable;

		$table->set_heading($headers);

	   return	$table = $table->generate($students);
	}

	/**
	 * Get the array key 
	 */
	
	private function getStudentPaymentsArray($students)
	{

	return array_map(function($student)
			{
			$progress = ($student['debit']>0) ? round(($student['credit']*100)/$student['debit']):0;

			$severity = ($progress < 50 ) ? 'red' : 'green';

			return [
			    'Names'					=>	$student['names'], 
			    'Reg #'					=>	$student['registration_number'], 
			    'Campus'				=>	$student['campus'], 
			    'Faculity'				=>	$student['Faculity'], 
			    'Department'			=>	$student['Department'], 
		        'Level'					=>	$student['level'], 
		        'InTake'				=>	$this->student->where('registration_number',$student['registration_number'])->first()->inTake(), 
			    'Mode'					=>	$student['mode_of_study'], 
			    'Debit'					=>	(float) $student['debit'],
			    'Credit'				=>	(float) $student['credit'],
			    'Balance'				=>	(float) $student['balance'],
			    'Progression'			=>	'<div class="progress progress-xs progress-striped active"><div class="progress-bar progress-bar-'.$severity.' " style="width:'.$progress.'%">
			    							</div></div><span class="badge bg-'.$severity.'">'.$progress.'%</span>' 
	    		];
		}, $students);
	}
}
