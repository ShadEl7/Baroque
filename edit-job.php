<?php
if (!isset($_GET['id'])) {
    echo "No job ID provided.";
    exit();
}
$id = intval($_GET['id']);
$jobs = file("jobs.txt", FILE_IGNORE_NEW_LINES);
if (!isset($jobs[$id])) {
    echo "Job not found.";
    exit();
}
list($title, $company, $location, $type, $description) = explode("|", $jobs[$id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Job - Baroque Amoka Careers</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f4f7fa; margin: 0; }
    header { background: #0a4275; color: white; padding: 20px; text-align: center; }
    .container {
      max-width: 800px; margin: 30px auto; background: white; padding: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 10px;
    }
    form { display: flex; flex-direction: column; }
    label { margin: 10px 0 5px; }
    input, select, textarea, button {
      padding: 10px; font-size: 1rem; border: 1px solid #ccc; border-radius: 5px;
    }
    button {
      background-color: #0a4275; color: white; border: none; margin-top: 20px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Edit Job</h1>
  </header>

  <div class="container">
    <form action="update-job.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $id; ?>" />

      <label>Job Title</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required />

      <label>Company Name</label>
      <input type="text" name="company" value="<?php echo htmlspecialchars($company); ?>" required />

      <label>Location</label>
      <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required />

      <label>Job Type</label>
      <select name="type" required>
        <option value="Full-Time" <?php if($type == "Full-Time") echo "selected"; ?>>Full-Time</option>
        <option value="Part-Time" <?php if($type == "Part-Time") echo "selected"; ?>>Part-Time</option>
        <option value="Remote" <?php if($type == "Remote") echo "selected"; ?>>Remote</option>
        <option value="Contract" <?php if($type == "Contract") echo "selected"; ?>>Contract</option>
      </select>

      <label>Job Description</label>
      <textarea name="description" rows="5" required><?php echo htmlspecialchars($description); ?></textarea>

      <button type="submit">Update Job</button>
    </form>
  </div>
</body>
</html>
