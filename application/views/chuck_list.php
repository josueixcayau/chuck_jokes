<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url("resources\bootstrap-5.1.3-dist\css\bootstrap.css") ?>">

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">id</th>
	  <th scope="col">created_at</th>
	  <th scope="col">icon</th>
	  <th scope="col">updated_at</th>
	  <th scope="col">url</th>
	  <th scope="col">value</th>
    </tr>
  </thead>
  <tbody>
	  <?php $count =1; ?>
	  <?php foreach ($list as $key => $value): ?>
		  <tr>
			  <th scope="row"><?php echo $count++ ?></th>
			  <td><?php echo $value["id"] ?></td>
			  <td><?php echo $value["created_at"] ?></td>
			  <td>
				  <img src="<?php echo $value["icon_url"] ?>" alt="<?php echo $value["id"] ?>">
			  </td>
			  <td><?php echo $value["updated_at"] ?></td>
			  <td><?php echo $value["url"] ?></td>
			  <td><?php echo $value["value"] ?></td>
		  </tr>

	  <?php endforeach; ?>
  </tbody>
</table>



<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="<?php echo base_url("resources\bootstrap-5.1.3-dist\js\bootstrap.js") ?>"></script>
