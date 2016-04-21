<?php
	require 'config.php';

	$abonents = getAllAbonents();

	if ($_SERVER['REQUEST_METHOD'] === 'POST'){
		$formData = array(
			'fullname' 	=> $_POST['fullname'],	
			'phone' 	=> $_POST['phone'],	
			'email' 	=> $_POST['email'],	
			'place' 	=> $_POST['place']	
		);

		if(isset($_POST['id'])){
			$formData['id'] = $_POST['id'];
			updateAbonent($formData);
			$abonents = getAllAbonents();
			foreach($abonents as $abonent){
				if($abonent['id'] == $formData['id']){
					$abonent['fullname'] = $formData['fullname'];
					$abonent['phone'] = $formData['phone'];
					$abonent['email'] = $formData['email'];
					$abonent['place'] = $formData['place'];
				}
			}
		}else if(isset($_POST['idfordelete'])){
			deleteAbonent($_POST['idfordelete']);
			$abonents = getAllAbonents();
			foreach($abonents as $key=>$abonent){
				if($abonent['id'] == $_POST['idfordelete']){
					unset($abonents[$key]);
				}
			}
		}else{
			$formData['id'] = addNewAbonent($formData);
			$abonents[] = $formData;
		}
	}

	function getAllAbonents(){
		$data = mysql_query("SELECT * FROM abonents") or die(mysql_error());
		$abonents = array();
		while ($row = mysql_fetch_assoc($data)) {
			$abonents[] = $row;
		}
		return $abonents;
	}

	function addNewAbonent($data){
		$sql = "INSERT INTO abonents (fullname, phone, email, place)
			VALUES ('" . $data['fullname'] . "', '" . $data['phone'] . "', '" . $data['email'] . "', '" . $data['place'] . "')";
		mysql_query($sql) or die(mysql_error());
		return mysql_insert_id();
	}

	function updateAbonent($data){
		$sql = "UPDATE abonents SET fullname = '" . $data['fullname'] . "', phone = '" . $data['phone'] . "', email = '" . $data['email'] . "', place = '" . $data['place'] . "' WHERE abonents.id = " . $data['id'];
		return mysql_query($sql) or die(mysql_error());
	}

	function deleteAbonent($id){
		$sql = "DELETE FROM abonents WHERE abonents.id = " . $id;
		return mysql_query($sql) or die(mysql_error());
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
										<td><?php echo $abonent['fullname']; ?></td>
										<td><?php echo $abonent['phone']; ?></td>
										<td><?php echo $abonent['email']; ?></td>
										<td><?php echo $abonent['place']; ?></td>
										<td>
											<button 
												type="button"
												class="btn btn-warning btn-sm" 
												data-toggle="modal" 
												data-target="#edit"
												data-id="<?php echo $abonent['id'] ?>"
												data-fullname="<?php echo $abonent['fullname'] ?>"
												data-phone="<?php echo $abonent['phone'] ?>"
												data-email="<?php echo $abonent['email'] ?>"
												data-place="<?php echo $abonent['place'] ?>"
												>редактировать</button>
											<button 
												class="btn btn-danger btn-sm"
												type="button"
												data-toggle="modal"
												data-target="#delete" 
												data-idfordelete="<?php echo $abonent['id'] ?>"
												data-fullname="<?php echo $abonent['fullname'] ?>"
												>удалить</button>
										</td>
									</tr>
								<?php } ?>

							</tbody>
						</table>
					</div>
				<?php } ?>
			</div>
		</div>

		<!-- modal add new-->
		<div class="modal fade" id="new" tabindex="-1" role="dialog">
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
						<input type="text" name="fullname" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="fullname">Номер телефона абонента</label>
						<input type="text" name="phone"name="phone" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="fullname">Email абонента</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="fullname">Место жительства абонента</label>
						<input type="text" name="place" class="form-control" required>
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

		<!-- modal edit -->
		<div class="modal fade" id="edit" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Редактирование абонента</h4>
		      </div>
		      <div class="modal-body">
		        <form action="/" method="post">
				  <input type="hidden" name="id" class="form-control">
		          <div class="form-group">
		            <label for="fullname" class="control-label">Фамилия, имя, отчество абонента</label>
		            <input type="text" class="form-control" name="fullname" id="fullname" required>
		          </div>
					<div class="form-group">
						<label for="fullname">Номер телефона абонента</label>
						<input type="text" name="phone" id="phone" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="fullname">Email абонента</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="fullname">Место жительства абонента</label>
						<input type="text" name="place" id="place" class="form-control" required>
					</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
		        <button type="submit" class="btn btn-primary">Обновить данные</button>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- modal delete -->
		<div class="modal fade" id="delete" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Удаление абонента</h4>
		      </div>
		      <div class="modal-body">
		        <form action="/" method="post">
				  <input type="hidden" name="idfordelete" class="form-control">
		          <div class="well">
		          	Удалить абонента <strong><span id="abonentName"></span></strong>
		          </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
		        <button type="submit" class="btn btn-danger">Удалить абонента</button>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" charset="utf-8"></script>
	<script src="js/script.js" charset="utf-8"></script>
</body>
</html>
