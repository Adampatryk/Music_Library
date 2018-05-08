<html>
    <?php 
    require "../php/header.html";
    require "../php/timeElapsed.php";
    ?>
    <body>
        <?php 
        
            require_once "../php/nav-bar.php";
            require '../php/connect.php';
        ?>

        <div class="content">
            <h1>add a new artist</h1>
            <form name="addArtistForm" method="GET" action="artist.php" onsubmit="return validateForm('addArtistForm')">
                <div class="form-input">
                    <input type="text" id="artistName" name="artistName" required>
                    <label for="artistName">name</label>
                </div>
                <br>
                <input type="submit" name="addArtist" value="add artist"/>
            </form>
        </div>
        
        <div class="content">
            <h1>artists</h1>

            <?php require_once "../php/search-bar.php"?>

            <table id="result">
                <tr>
                    <th class="ascending" onclick="sort(0)">name<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(1)">added<img src="../res/arrow_up.png"/></th>
                    <th></th>
                </tr>

                <?php
                    if(isset($_GET['addArtist'])){
                        header("Location: artist.php");

                        $artistName = $_GET['artistName'];
                        $sql = "INSERT INTO artist VALUES (null, '$artistName', now())";
                        mysqli_query($conn, $sql);
                    }
                    $sql = "SELECT * FROM artist ORDER BY artName";
                    if (isset($_GET['searchText'])){
                        $searchText = $_GET['searchText'];
                        $sql = $sql . " WHERE artName LIKE '%$searchText%'";
                    }
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)){
                        $artID = $row['artID'];
                        $artName = $row['artName'];

                        echo "<tr onclick='window.location=\"/pages/viewArtist.php?id=$artID\"'>";
                        
                        echo "<td>$artName</td>";
                        echo "<td>" . timeSince($row['dateAdded']) . "</td>";
                        echo "<td><input class=editIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($artID, \"$artName\", \"artist\")'/>";
                        echo "<input class=deleteIcon type='image' src='../res/edit_pencil.png' onclick='window.location=\"/pages/viewArtist.php?edit=true&id=$artID\"'/></td>";
                        
                        echo "</tr>";

                    }
                    mysqli_close($conn);
                ?>

            </table>
        </div>
    </body>
</html>
