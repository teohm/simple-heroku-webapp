<?php

# Get environment variable DATABASE_URL
$db_url = getenv("DATABASE_URL");
echo ">> DATABASE_URL: $db_url\n\n";

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

echo ">> PDO Settings: $pdo_settings\n\n";

# Create table blog_posts
$create_table_sql = "
  DROP TABLE IF EXISTS blog_posts;
  CREATE TABLE blog_posts (
    id SERIAL PRIMARY KEY,
    title varchar(255),
    body text
  );
";
$DB->exec($create_table_sql);

echo ">> Create blog_posts table:\n";
var_dump($DB->errorInfo());
echo "\n";

# Add sample blog post
$sample_post = array('title' => 'Hello Heroku!', 'body' => 'My first heroku app!!');
$add_post_sql = "INSERT INTO blog_posts(title, body) VALUES(:title, :body)";
$add_post = $DB->prepare($add_post_sql);

if ( $add_post->execute($sample_post) ) {
  echo ">> Add blog post successfully\n\n";
}
else {
  echo ">> Add blog post failed:\n";
  var_dump($DB->errorInfo());
  echo "\n";
}
?>
