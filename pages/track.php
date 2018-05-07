<html> 
    <?php 
        require "../php/header.html";
        require "../php/timeElapsed.php";
    ?>
    <body>
        <?php require_once "../php/nav-bar.php";?>
        <?php require_once "../php/search-bar.php";?>

        <div class="content">
            <h1>add a new track</h1>
            <form method="GET" action="track.php">
                <div class="form-input">
                    <input type="text" id="trackTitle" name="trackTitle" required>
                    <label for="trackTitle">title</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="trackLength" name="trackLength" required>
                    <label for="trackLength">length(s)</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="cdID" name="cdID" required>
                    <label for="cdID">cd</label>
                </div>
                <br>
                <input type="submit" name="addTrack" value="add track"/>
            </form>
        </div>

        <div class="content">
            <h1>tracks</h1>

            <table>
                <tr>
                    <th>title</th>
                    <th>cd</th>
                    <th>artist</th>
                    <th>length</th>
                    <th>added</th>
                    <th></th>
                    <th></th>
                </tr>

                <?php
                    require '../php/connect.php';

                    if(isset($_GET['addTrack'])){
                        header("Location: track.php");

                        $trackTitle = $_GET['trackTitle'];
                        $trackLength = $_GET['trackLength'];
                        $cdID = $_GET['cdID'];

                        $sql = "INSERT INTO track(trackTitle, trackLength, cdID, dateAdded) VALUES ('$trackTitle', '$trackLength', $cdID, now())";
                        mysqli_query($conn, $sql);
                    }

                    $sql = "SELECT * FROM track ORDER BY track.trackTitle";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)){

                        $trackID = $row['trackID'];
                        $trackTitle = $row['trackTitle'];

                        $cdID = $row['cdID'];
                        $sql = "SELECT cd.artID, cd.cdTitle FROM cd WHERE cdID = $cdID";
                        $tmpResult = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                        $cdTitle = $tmpResult['cdTitle'];
                        
                        $artID = $tmpResult['artID'];
                        $sql = "SELECT artist.artName FROM artist WHERE artID = $artID";
                        $artName = mysqli_fetch_assoc(mysqli_query($conn, $sql))['artName'];



                        $trackLength = $row['trackLength'];
                        $timeElapsed = timeSince($row['dateAdded']);

                        echo "<tr>";

                        echo "<td>$trackTitle</td>";
                        echo "<td>$cdTitle</td>";
                        echo "<td>$artName</td>";
                        echo "<td>$trackLength</td>";
                        echo "<td>$timeElapsed</td>";
                        echo "<td><input class=editIcon type='image' src='../res/edit_pencil.png' onclick='confirmDelete($trackID, \"$trackTitle\", \"track\")'/></td>";
                        echo "<td><input class=deleteIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($trackID, \"$trackTitle\", \"track\")'/></td>";
                        
                        echo "</tr>";
                    }
                    mysqli_close($conn);
                ?>
        </div>
    </body>
</html>
