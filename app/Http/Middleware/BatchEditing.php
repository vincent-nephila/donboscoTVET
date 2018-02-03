<?php

namespace App\Http\Middleware;

use Closure;

class BatchEditing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if($request->ajax()){
            $batch = $request->ajax('batch');
        }elseif($request->route()){
            $batch = $request->route('batch');
        }
      //  $isactive = \App\CtrSchoolYear::where('period',$batch)->where('active',1)->first();
        
    //    if($isactive){
            if($request->ajax()){
                return $request;
            }else{
                return $batch;
            }
            //return $next($request);
            
            
  //      }
        
//        return back()->withErrors(['warning'=>'You are trying to access data of an inactive batch.']);
    }
}
