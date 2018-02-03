<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::auth();

Route::get('/', 'HomeController@index');

//Add a personnel
Route::get('/addteacher', 'Personnel\AddNewTeacher@index')->name('addteacher');
Route::post('/saveteacher', 'Personnel\AddNewTeacher@save')->name('saveteacher');

//Assign and View Personnel
Route::get('/personnel/list', 'Personnel\AssignPersonnel@alllist')->name('personnellist');
Route::get('/personnel/{idno}', 'Personnel\AssignPersonnel@view')->name('personnelview');
Route::post('/assign', 'Personnel\AssignPersonnel@assignrole')->name('assignpersonnel');

//----Ajax----//Assign and View Personnel
Route::get('/unassign/{id}', 'Personnel\AssignPersonnel@unassignrole')->name('unassignpersonnel');
Route::get('/assignId', 'Personnel\AssignPersonnel@assignId')->name('assignRole');

Route::get('/getassigncourse/{batch}', 'Personnel\Helper@get_SectionCourse');
Route::get('/getassignsection/{batch}/{course_id}', 'Personnel\Helper@get_SectionSection');

Route::get('/getassignsubject/{batch}', 'Personnel\Helper@get_ClassSubjects');
Route::get('/getassignclass/{batch}/{subject}', 'Personnel\Helper@get_ClassCLass');

//Courses
/*|_*/Route::get('/course/{course_code}', 'ClassManagement\CourseController@view')->name('courseview');

//Subject Classes and Sections
/*|_*/Route::get('/classmanagement', 'ClassManagement\MainController@mainManagement')->name('classlist');
/*| */
/*|_*/Route::post('/createsection', 'ClassManagement\MainController@createsection')->name('createsection');
/*| */Route::get('/deletesection/{id}', 'ClassManagement\MainController@deletesection')->name('deletesection');
/*| */Route::get('/section/{id}', 'ClassManagement\SectionController@viewsection')->name('viewsection');
/*| */Route::post ('/sectionteacher', 'ClassManagement\SectionController@assignAdviser')->name('assignsectionteacher');
/*| */
/*| */Route::get('/sectioning/{batch}', 'ClassManagement\Sectioning@viewsectioning')->name('sectioning');
/*| */
/*| */
/*|_*/Route::post('/createclass', 'ClassManagement\MainController@createclass')->name('createclass');
/*| */Route::get ('/deleteclass/{id}', 'ClassManagement\MainController@deleteclass')->name('deleteclass');
/*| */Route::get ('/class/{id}', 'ClassManagement\ClassController@viewclass')->name('viewclass');
/*| */Route::post ('/classteacher', 'ClassManagement\ClassController@assignclassteacher')->name('assignclassteacher');
/*| */
/*| */Route::get ('/classassignment/{batch}', 'ClassManagement\ClassAssignment@viewClassification')->name('classassignment');
/*| */
/*| */Route::post('/assignsubjectclass', 'ClassManagement\ClassController@assignsubjectclass')->name('assignsubjectclass');
/*| */Route::get('/unassignsubjectclass/{id}', 'ClassManagement\ClassController@unassignsubjectclass')->name('unassignsubjectclass');

//----Ajax----//Subject Classes and Sections
Route::get('/getbatchsubjects/{batch}', 'ClassManagement\Helper@get_BatchSubjects');
Route::get('/getAvailableClass', 'ClassManagement\Helper@getAvailableClass');
Route::get('/getAdviser/{class}', 'ClassManagement\Helper@getAdvisers');

//----Ajax----//Sectioning and Class Allocation
Route::get('/getcoursestudents', 'ClassManagement\Sectioning@get_courseStudents')->name('coursestudentlist');
Route::get('/getcourseSections', 'ClassManagement\Sectioning@getcourseSections')->name('get_coursesections');
Route::get('/getsectionStudents', 'ClassManagement\Sectioning@getSectionsStudents')->name('get_sectionStudents');
Route::get('/updatestudentSection', 'ClassManagement\Sectioning@update_studentSection')->name('update_studentSection');

Route::get('/subjectstudentlist', 'ClassManagement\ClassAssignment@get_subjectStudent')->name('subjectstudentlist');
Route::get('/getsubjectclasses', 'ClassManagement\ClassAssignment@get_subjectClasses')->name('get_subjectclasses');
Route::get('/getclassInfo', 'ClassManagement\ClassAssignment@get_classInfo')->name('get_classInfo');
Route::get('/getclassStudents', 'ClassManagement\ClassAssignment@get_classStudents')->name('get_classStudents');
Route::get('/updatestudentClass', 'ClassManagement\ClassAssignment@update_studentClass')->name('update_studentClass');

//Grade Submission
/*|_*/Route::get('/grades/view/{class}', 'GradeSubmission@viewClassGrades')->name('viewclassgrades');
/*| */Route::get('/updategrade', 'GradeSubmission@updateGrade')->name('updategrade');
/*| */
/*|_*/Route::get('/grades/submit/{class}', 'GradeSubmission@submitandLockGrades')->name('submitfinalizedgrade');
/*| */
/*|_*/Route::get('/updateAttendance', 'AttendanceController@updateStudentAttendance');
/*| */Route::post('/forwardAttendance', 'AttendanceController@forwardAttendance')->name('forwardAttendance');
/*| */
/*|_*/Route::get('/showAttitude/{batch}/{idno}/{sem}', 'AttitudeController@viewAttitude')->name('showAttitude');
/*| */Route::get('/updatestudentattitude', 'AttitudeController@update_studentAttitude')->name('updateStudentAttitude');
/*| */Route::post('/forwardAttitude', 'AttitudeController@forwardAttitude')->name('forwardAttitude');



//Grade Report
/*|_*/Route::get('/sheeta/{batch}', 'Reports\SheetAController@sheetAList')->name('sheetaview');
/*| */Route::get('/sheeta/section/{section}', 'Reports\SheetAController@sheetAView')->name('sectionsheeta');
/*| */
/*|_*/Route::get('/sheetb/{batch}', 'Reports\SheetBController@sheetAView')->name('sheetbview');
/*| */Route::get('/sheetb/section/{section}', 'Reports\SheetBController@sheetBView')->name('sectionsheetb');
/*| */
/*| */
/*|_*/Route::get('/showstudentattendance/{sectionid}/{semester}', 'AttendanceController@viewStudentAttendance')->name('showStudentAttendance');

//----Ajax----//Grade Reports
Route::get('/section_grades', 'Reports\SheetAController@viewSubjectGrades')->name('section_subject_view');
Route::get('/section_grades_info', 'Reports\SheetAController@viewSubjectInfo')->name('section_subject_details');
Route::get('/forwardSectionSubject', 'Reports\SheetAController@forwardSectionSubject')->name('forwardSectionSubject');
