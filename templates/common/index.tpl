{include $header1}
{include $header2}

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">LMS</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
	 <div >
            <h3>Matlab License details</h3><br/>
      </div>
    <div class="row">
	
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{$countLicense['total']}</div>
                            <div>Total Licenses!</div>
                        </div>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#new_comments">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <!-- /.panel-heading -->
    
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{$countLicense['available']}</div>
                            <div>Availabe Licenses!</div>
                        </div>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#new_task">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            
            
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{$countLicense['used']}</div>
                            <div> Used Licenses!</div>
                        </div>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#new_order">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            
     
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{$countLicense['dead']}</div>
                            <div> Dead Licenses!</div>
                        </div>
                    </div>
                </div>
                <a href="#" data-toggle="modal" data-target="#support_ticket">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            
    
    </div>
</div>
<!-- /.row -->
{include $footer}
