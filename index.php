<?php
	require 'config.php';

	$abonents = getAllAbonents();

	if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // рыба
		$abonents[] = array(
			'id'				=> 3,
			'fullname'	=> 'Сидоров Сидр Сидорович',
			'phone'			=> '+375295426598',
			'email'			=> 'sidr@sidr.com',
			'place'			=> 'г. Брест, ул. Ленина, 12'
		);
	}

	function getAllAbonents(){
		$data = mysql_query("SELECT * FROM abonents") or die(mysql_error());
		$abonents = array();
		while ($row = mysql_fetch_assoc($data)) {
			$abonents[] = $row;
		}
		return $abonents;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>php-crud (телефонная книга)</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.min.css">
</head>
<body>

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">php-crud (телефонная книга)</a>
	    </div>
	  </div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="well">
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#new">Добавить абонента</button>
					<span class="pull-right">Всего абонентов: <?php echo count($abonents); ?></span>
				</div>

				<?php if(count($abonents) == 0){ ?>
					<div class="well text-center">
							<h3>Нет абонентов в базе данных. Добавьте...</h3>
					</div>
				<?php } else { ?>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>id абонента</th>
									<th>Фамилия, имя, отчество</th>
									<th>Номер телефона</th>
									<th>Email</th>
									<th>Место жительства</th>
									<th></th>
								</tr>
							</thead>
							<tbody>

								<?php foreach($abonents as $abonent){ ?>
									<tr>
										<td><?php echo $abonent['id']; ?></td>
										<td><?php echo $abonent['fullname']; ?></td>
										<td><?php echo $abonent['phone']; ?></td>
										<td><?php echo $abonent['email']; ?></td>
										<td><?php echo $abonent['place']; ?></td>
										<td>
											<button class="btn btn-warning btn-sm">редактировать</button>
											<button class="btn btn-danger btn-sm">удалить</button>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>
				<?php } ?>
			</div>
		</div>

		<!-- modals -->
		<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Добавление абонента</h4>
		      </div>
		      <div class="modal-body">
		        <form class="" action="/" method="post">
							<div class="form-group">
								<label for="fullname">Фамилия, имя, отчество абонента</label>
								<input type="text" name="fullname" class="form-control">
							</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
		        <button type="submit" class="btn btn-primary">Добавить</button>
		      </div>
					  </form>
		    </div>
		  </div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" charset="utf-8"></script>
</body>
</html>
