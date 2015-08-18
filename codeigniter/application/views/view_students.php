<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
		<title>CISeed Project</title>

		<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<style type="text/css">
			body {
			  padding-top: 20px;
			  padding-bottom: 20px;
			}
			.navbar {
			  margin-bottom: 20px;
			}
		</style>
	</head>
	<body>
		<div class="container">

			<div class="page-header" role="main">
				<p>
					<button type="button" class="btn btn-lg btn-primary" id="view-students">View Students</button>
					<button type="button" class="btn btn-lg btn-info" id="generate-random-data">Generate Random Student Data</button>
					<button type="button" class="btn btn-lg btn-success" id="update-students-data">Update Student Data</button>
				</p>
				<div class="alert alert-success alert-dismissible" id="message" style="display:none"></div>
			</div>

			<div class="container">
				<div class="table-responsive">
					<table class="table table-hover table-bordered" id="students-data" style="display:none">
						<caption><strong>Students Data</strong></caption>
						<thead>
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Password</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>

				<div class="table-responsive">
				<table class="table table-hover table-bordered" id="students-random-data" style="display:none">
					<caption><strong>Random Students Data</strong></caption>
					<thead>
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>Password</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>

		</div>

	<script type="text/javascript">
		(function() {

			console.log($);
			var studentCount = 0;
			
			var baseUrl = "/interview-php/codeigniter/";

			$(document).ready(function() {
				$("#students-data").hide();
				$("#students-random-data").hide();
				$("#generate-random-data").prop('disabled', true);
				$("#update-students-data").prop('disabled', true);
				$("#message").hide();
			});

			$("#view-students").click(function() {
				loadAndDisplayStudentData(function() {
					$("#generate-random-data").prop('disabled', false);
					displayMessage("Students data loaded successfully!");
				});

			});

			$("#generate-random-data").click(function() {
				var randomData = generateRandomUsernameAndPassword();
				$("#students-random-data").data("json-data", randomData);
				displayResult("students-random-data", randomData);
				$("#update-students-data").prop('disabled', false);
				displayMessage("Students random data generated successfully!");
				$("#students-random-data").show();
			});

			$("#update-students-data").click(function() {
				updateStudentData(loadAndDisplayStudentData);
				$("#students-random-data").hide();
			});

			function loadAndDisplayStudentData(callback) {
				$.getJSON(baseUrl + "api_students/all", function(data) {
					data = data.data;
					studentCount = data.length;
					$("#students-data").data("json-data", data);
					displayResult("students-data", data);
					callback();
				});
			}

			function updateStudentData(callback) {
				randomStudentData = $("#students-random-data").data("json-data");
				if(randomStudentData != null && randomStudentData.length > 0) {
					$.ajax({
						type: "POST",
						url: baseUrl + "api_students/mass_update",
						data: {"data": randomStudentData},
						statusCode: {
							200: function() {
									displayMessage("Students data updated successfully!");
									callback();
							}
						},
						dataType: "json"
					});
				} else {
					alert('There is nothing to update.');
				}
			}

			function displayMessage(msg) {
				$("#message").html(msg).show();
			}

			function displayResult(tableId, data) {
				// Clean up tbody before we display anything
				$("#" + tableId +" tbody tr").remove();
				// Display each record
				$.each(data, function(id, value) {
						$("#" + tableId +" tbody").append(tableRow(id, value));
				});
				$("#" + tableId).show();
			}

			function tableRow(row_id, row_value) {
				return '<tr><th scope="row">' + (row_id + 1) + '</th><td>' + row_value.user_name + '</td><td>' + row_value.password + '</td></tr>';
			}

			function generateRandomUsernameAndPassword() {
				var usernameSeed = 'user';
				var passwordSeed = 'secret';
				var randomStudentData = [];
				var studentData = $("#students-data").data("json-data");
				if(studentCount > 0) {
					for(var i = 0; i < studentCount; i++) {
						var student = {};
						student.id = studentData[i].id;
						student.user_name = usernameSeed + parseInt(Math.random() * 100);
						student.password = usernameSeed + parseInt(Math.random() * 100);
						randomStudentData.push(student);
					}
				}
				return randomStudentData;
			}

		})();
	</script>

	</body>
</html>
