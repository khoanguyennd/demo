<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Upload excel</title>
</head>
<body>
	<form action="excel" method="post" enctype="multipart/form-data">
		@csrf
		<label for="">Upload excel</label><br>
		<input type="file" name="file"><br>
		<button type="submit">Submit</button>
	</form>
</body>
</html>