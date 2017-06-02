<?php
function put_html($name,$data) {
    $contents = file_get_contents("resources/snippets/{$name}.html");
    foreach($data as $key => $value) {
        $contents = str_replace("{" . $key . "}", $value, $contents);
    }
    
    echo $contents;
}

$site_files = scandir("sites");
$site_list = array();
$count = 0;

foreach($site_files as $file) {
    if(!(is_dir("sites/{$file}") && $file != "." && $file != "..")) {
        $site_files = array_diff($site_files, [$file]);
    }
}

foreach($site_files as $file) {
    if(file_exists("sites/{$file}/about.json")) {
        $about = json_decode(file_get_contents("sites/{$file}/about.json"), true);
        
        if($about["show"] == true) {
            $site_list[$count] = [
                "name" => $about["name"],
                "description" => $about["description"],
                "development" => $about["development"] ? "dev" : "",
                "path" => "sites/{$file}"
            ];

            $count ++;
        } else {
            $site_list[$count] = [
                "name" => "Hidden Site",
                "description" => "This site has been hidden.",
                "development" => "hidden",
                "path" => ""
            ];

            $count ++;
        }
    } else {
        $site_list[$count] = [
            "name" => "Unknown Site",
            "description" => "This site has no associated information.",
            "development" => "unknown",
            "path" => "sites/{$file}"
        ];
        
        $count ++;
    }
}

usort($site_list, function($a, $b) {
    if ($a["development"] == "dev" && $b["development"] != "dev") {
        return 1;
    } else if ($a["development"] == "unknown" && $b["development"] != "unknown") {
        return 1;
    } else if ($a["development"] == "hidden" && $b["development"] != "hidden") {
        return 1;
    } else if ($a["development"] != "dev" && $b["development"] == "dev") {
        return -1;
    } else if ($a["development"] != "unknown" && $b["development"] == "unknown") {
        return -1;
    } else if ($a["development"] != "hidden" && $b["development"] == "hidden") {
        return -1;
    } else {
        return 0;
    }
});


$real_file_amount = count($site_files);
$shown_file_amount = count($site_list);

?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="resources/main.css">
    </head>
    <body>
        <h1>sites@localhost</h1><br><br>
        <div class="cardholder">
<?php
foreach($site_list as $sites) {
    put_html("card",$sites);
}
echo "<h3></h3>";
?>
        </div>
    </body>
</html>