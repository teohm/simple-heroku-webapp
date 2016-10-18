<?php
# Get environment variable DATABASE_URL
$db_url = getenv("DATABASE_URL");

# Extract db connection info
$db_settings = parse_url($db_url);
$host     = $db_settings['host'];
$port     = $db_settings['port'];
$db_name  = substr($db_settings['path'], 1);
$user     = $db_settings['user'];
$password = $db_settings['pass'];

# Setup PDO db connection
$pdo_settings = "pgsql:host=$host;port=$port;dbname=$db_name;user=$user;password=$password";
$DB = new PDO($pdo_settings);

# Select all blog posts
$all_posts_sql = 'SELECT * FROM blog_posts';
$posts = $DB->query($all_posts_sql);
?>
<html>
<body>
  <h1>My Blog</h1>

<?php
if ($posts == FALSE) {
  print("<p>(database not setup yet)</p>");
}
else {
  foreach ($posts as $post) {
    print("<h2>{$post['title']}</h2><p>{$post['body']}</p><br>");
  }
}
?>

</body>
</html>
