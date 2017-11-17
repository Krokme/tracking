<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Issue Tracking System: Tickets</title>

    <link href="<?php echo PROJECT_PATH; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo PROJECT_PATH; ?>css/datatables.bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="<?php echo PROJECT_PATH; ?>css/custom.less">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <div class="modal fade" id="editTicket" tabindex="-1" role="dialog" aria-labelledby="editTicket" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content"></div>
      </div>
  </div>

  <header class="header">
      <div class="container">
          <div class="row">
              <div class="col-sm-6"><h1>Issue Tracking System <small>Tickets</small></h1></div>
              <div class="col-sm-6 main-menu">
                  <div class="dropdown">
                      <button class="btn dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown">
                          MENU
                          <span class="glyphicon glyphicon-align-justify"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu">
                          <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo PROJECT_PATH; ?>">Ticket list</a></li>
                          <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo PROJECT_PATH; ?>tickets/edit" data-toggle="modal" data-target="#editTicket">Add ticket</a></li>
                          <li role="presentation" class="divider"></li>
                          <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo PROJECT_PATH; ?>login/logout">Logout</a></li>
                      </ul>
                  </div>

              </div>
          </div>
      </div>
  </header>

  <div class="header-2">
      <div class="container">
          <div class="row">
              <div class="col-sm-12"><h3>Tickets</h3></div>
          </div>
      </div>
  </div>

  <div class="container" id="content">
      <div class="col-sm-12">

          <a href="<?php echo PROJECT_PATH; ?>tickets/edit" data-toggle="modal" data-target="#editTicket">Add ticket</a>

          <table id="tickets" class="table table-striped table-bordered" width="100%" cellspacing="0">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Created</th>
                  <th>Updated</th>
                  <th>Priority</th>
                  <th>Status</th>
                  <th>Project</th>
                  <th>&nbsp;</th>
              </tr>
              </thead>
              <tfoot>
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Created</th>
                  <th>Updated</th>
                  <th>Priority</th>
                  <th>Status</th>
                  <th>Project</th>
                  <th>&nbsp;</th>
              </tr>
              </tfoot>
          </table>
      </div>
  </div>

  <footer class="header">
      <div class="container"><p>&copy; 2017 All Rights Reserved</p></div>
  </footer>

  <script src="<?php echo PROJECT_PATH; ?>js/jquery-3.2.1.min.js"></script>
  <script src="<?php echo PROJECT_PATH; ?>js/less.min.js"></script>
  <script src="<?php echo PROJECT_PATH; ?>js/bootstrap.min.js"></script>
  <script src="<?php echo PROJECT_PATH; ?>js/modal.min.js"></script>
  <script src="<?php echo PROJECT_PATH; ?>js/jquery.dataTables.min.js"></script>
  <script src="<?php echo PROJECT_PATH; ?>js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo PROJECT_PATH; ?>js/validator.min.js"></script>
  <script src="<?php echo PROJECT_PATH; ?>js/tickets.min.js"></script>

  </body>
</html>

