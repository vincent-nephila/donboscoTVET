
<?php
$positions = \App\UsersPosition::where('idno',Auth::user()->idno)->get()->pluck('position_id')->toArray();
$activebatches = \App\CtrSchoolYear::where('department','TVET')->where('active',1)->get();

$classes = \App\TvetClass::where('adviser',Auth::user()->idno)->whereIn('batch',$activebatches->pluck('period')->toArray())->orderBy('batch','ASC')->get();
$advisory = \App\TvetSection::where('adviser_id',Auth::user()->idno)->whereIn('batch',$activebatches->pluck('period')->toArray())->orderBy('batch','ASC')->get();
$headed = \App\TvetCourse::where('course_head',Auth::user()->idno)->get();

?>



<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset(Helper::getprofilePic(Auth::user()->idno))}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Helper::getName(Auth::user()->idno)}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        
        <!--Get all Course-->
        @if(count($headed)> 0 )
        <li class="header">COURSE</li>
        @foreach($headed as $course)
        <li><a href="{{route('courseview',['course_code'=>$course->course_id])}}"><i class="fa fa-circle-o"></i> <span>{{$course->course}}</span></a></li>
        @endforeach
        @endif
        <!--Get all Course-->

        <!--Get all section advisory-->
        @if(count($advisory)> 0 )
        <li class="header">SECTIONS</li>
        <?php $batches = $advisory->groupBy('batch')->groupBy('course_id'); ?>
        @foreach($batches as $batch)
            @foreach($batch as $course)
                <li class="treeview">
                  <a href="#">
                      <i class="fa fa-list" aria-hidden="true"></i> <span>{{$course->pluck('course_id')->last()}}</span><span class="pull-right">Batch {{$course->pluck('batch')->last()}}</span>
                  </a>
                  <ul class="treeview-menu">
                    @foreach($course as $section)
                    <li><a href="{{route('sectionsheeta',['class'=>$section->id])}}"><i class="fa fa-circle-o"></i>{{$section->section}}</a></li>
                    @endforeach
                  </ul>
                </li>
            @endforeach
        @endforeach
        @endif
        <!--Get all section advisory-->

        <!--Get all the subjects assigned to an adviser-->
        @if(count($classes)>0)
        <li class="header">SUBJECTS</li>
        <?php $subject_batches = $classes->groupBy('batch'); ?>
        @foreach($subject_batches as $batch)
            <?php $subjects = $classes->groupBy('subject'); ?>
            @foreach($subjects as $subject)
            <li class="treeview">
              <a href="#">
                  <i class="fa fa-list" aria-hidden="true"></i> <span>{{Helper::subjectName($subject->pluck('subject')->last())}}</span><span class="pull-right">Batch {{$subject->pluck('batch')->last()}}</span>

              </a>
              <ul class="treeview-menu">
                @foreach($subject as $class)
                <li><a href="{{route('viewclassgrades',['class'=>$class->id])}}"><i class="fa fa-circle-o"></i>{{$class->section}}</a></li>
                @endforeach
              </ul>
            </li>
            @endforeach
        @endforeach
        @endif
        <!--/Get all the subjects assigned to an adviser-->
        
        @if(in_array(6,$positions))
        <!--Only for Technical Assistant Director-->
        <li class="header">ADMIN</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cog" aria-hidden="true"></i> <span>Administration</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cog" aria-hidden="true"></i> <span>Personnels</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul  class="treeview-menu">
                <li><a href="{{route('addteacher')}}"><i class="fa fa-plus"></i>Add Personnel</a></li>
                <li><a href="{{route('personnellist')}}"><i class="fa fa-list"></i> Personnel List</a></li>      
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-cog" aria-hidden="true"></i> <span>Class Management</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul  class="treeview-menu">
                <li><a href="{{url('classmanagement')}}"><i class="fa fa-book"></i> <span>Section / Class Control</span></a></li>
                <li class='treeview'>
                    <a href="#"><i class="fa fa-cog" aria-hidden="true"></i> <span>Sectioning</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class='treeview-menu'>
                        @foreach($activebatches as $batch)
                        <li><a href="{{route('sectioning',['batch'=>$batch->period])}}"><i class="fa fa-circle-o"></i><span>Batch {{$batch->period}}</span></a></li>
                        @endforeach
                    </ul>
                </li>
                <li class='treeview'>
                    <a href="#"><i class="fa fa-cog" aria-hidden="true"></i> <span>Class Assignment</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class='treeview-menu'>
                        @foreach($activebatches as $batch)
                        <li><a href="{{route('classassignment',['batch'=>$batch->period])}}"><i class="fa fa-circle-o"></i><span>Batch {{$batch->period}}</span></a></li>
                        @endforeach
                    </ul>
                </li>
                
              </ul>
            </li>
            
          </ul>
        </li>
        <!--/Only for Technical Assistant Director-->
        @endif
        
        
        @if(in_array(6,$positions))
        <li class="header">REPORTS</li>
        @foreach($activebatches as $batch)
        <li class="treeview">
          <a href="#">
              <i class="fa fa-circle-o" aria-hidden="true"></i><span>Batch {{$batch->period}}</span>

          </a>
          <ul class="treeview-menu">
              <li><a href="{{route('sheetaview',['batch'=>$batch->period])}}"><i class="fa fa-file-text-o text-red"></i> <span>Sheet A</span></a></li>
            <li><a href="{{route('sheetbview',['batch'=>$batch->period])}}"><i class="fa fa-file-text-o text-yellow"></i> <span>Sheet B</span></a></li>
          </ul>
        </li>
        @endforeach
        @endif
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>