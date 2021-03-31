<?php

// connect database and controll connection
include('config/db_connect.php');

// check GET request id param
if(isset($_GET['id'])){
    
    // escape sql chars
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // make sql
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    // get the query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);

}

// initialize the variables
$id = $pizza['id'];
$email = $pizza['email'];
$title = $pizza['title'];
$ingredients = $pizza['ingredients'];
$errors = array('email' => '', 'title' => '', 'ingredients' => '');

// form validation
if(isset($_POST['submit'])){
    
    // check email
    if(empty($_POST['email'])){
        $errors['email'] = 'An email is required <br />';
    } else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'unvalid email <br>';
        }
    }
    
    // check title
    if(empty($_POST['title'])){
        $errors['title'] = 'A title is required <br />';
    } else{
        $title = $_POST['title'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
            $errors['title'] = 'Unvalid Title : only letters and spaces are allowed <br>';
        }
    }

    // check ingredients
    if(empty($_POST['ingredients'])){
        $errors['ingredients'] = 'At least one ingredient is required <br />';
    } else{
        $ingredients = $_POST['ingredients'];
        if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
            $errors['ingredients'] = 'Ingredients must be a comma separated list';
        }}

    // update the info of the pizza
	if(array_filter($errors)){
			//echo 'errors in form';
            $id = $_POST['id'];
	} else {
			// escape sql chars
            $id = $_POST['id'];
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

            $sql = "UPDATE `pizzas` SET 
            `email` = '$email', 
            `title` = '$title', 
            `ingredients` = '$ingredients' 
            where `id`=".$id ;

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
	}

} // end POST check

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Update the Pizza</h4>
    <form class="white" action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label>Your Email</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>
        <label>Pizza Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['title']; ?></div>
        <label>Ingredients (comma separated)</label>
        <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
        <div class="red-text"><?php echo $errors['ingredients']; ?></div>
        <div class="center">
            <input type="submit" name="submit" value="Update" class="btn z-depth-0">
        </div>
    </form>
</section>
 
<?php include('templates/footer.php'); ?>

</html>