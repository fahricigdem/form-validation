<?php

    // connect database and controll connection
    include('config/db_connect.php');

    // write query
    $sql = "SELECT title, ingredients, id FROM pizzas ORDER BY created_at ";

    // make query & get results
    $results = mysqli_query($conn,$sql);

    // fetching results as array
    $pizzas = mysqli_fetch_all($results, MYSQLI_ASSOC);
    
    // free results memory
    mysqli_free_result($results);

    // close connection
    mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<h4 class="center grey-text">Pizzas!</h4>

<div class="container">
    <div class="row">

        <?php foreach($pizzas as $pizza): ?>

            <div class="col s6 md3">
                <div class="card z-depth-0">
                    <img src="img/pizza.svg"class="pizza">
                    <div class="card-content center">
                        <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                        <ul class="grey-text">
								<?php foreach(explode(',', $pizza['ingredients']) as $ing): ?>
									<li><?php echo htmlspecialchars($ing); ?></li>
								<?php endforeach; ?>
							</ul>
                    </div>
                    <div class="card-action right-align">
                        <a class="brand-text" href="detail.php?id=<?php echo $pizza['id'] ?>">more info</a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>

<?php include('templates/footer.php'); ?>

</html>


