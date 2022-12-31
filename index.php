<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel = "stylesheet" href = "bootstrapcss.css">
    
    <title></title>
</head>

<body>
    
    <?php
        class MyDB extends SQLite3 {
            function __construct() {
                $this->open('chinook.db');
            }
        }
        $db = new MyDB();
                        
        if(!$db) {
            echo $db->lastErrorMsg();
        } #else {
            #echo "Opened database successfully\n";
        #}
        
        $idt = explode("/", $_SERVER['PATH_INFO']);
        

        $id = $idt[2];
        
        

        $sqlSONGS =<<<EOF
            SELECT 
                TrackId,
                tracks.Name AS Song,
                tracks.AlbumId,
                MediaTypeId,
                GenreId,
                Composer,
                Milliseconds, 
                Bytes,
                UnitPrice,
                artists.Name,
                Title
            FROM tracks
            INNER JOIN albums
                ON tracks.albumid = albums.albumid
            INNER JOIN artists
                ON albums.artistid = artists.artistid
            WHERE artists.artistid = $id;
        EOF;


                        
        $ret = $db->query($sqlSONGS);
        
    ?>
    

    <nav class = "navbar navbar-expand-lg bg-dark navbar-dark py-3">
        <div class="container">
            <a href = "#" class = "navbar-brand" > 
                <?php 
                    $row = $ret->fetchArray(SQLITE3_ASSOC);
                    echo $row['Name'];
                ?>
            </a>
        </div>
    </nav>
    

    <?php
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
    ?>
            <section class="bg-dark text-light p-5 p-lg-0 pt-lg-5 m-5 text-center text-sm-start">
                <div class="container">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div>
                            <h2>
                                <?php
                                    echo $row['Song'];
                                ?>

                            </h2>

                            <p>
                                From The Album " <?php echo $row['Title']; ?>"
                            </p>
                        </div>
                    </div>
                </div>
            </section>

    <?php    
        }
                        
        $db->close();
    ?>


</body>
