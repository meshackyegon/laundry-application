<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome To Hendry Laundry</title>
    <link rel="stylesheet" type="text/css"href="laundrywash.css" >
</head>
<body>
<div class="header">
	<h2>Welcome to Laundry washing</h2>
</div>
    <div class="container">
        <div class="paragraph"><p>3 shirts at sh.100, 2 trousers at sh.100, 1 sweater/jacket at sh.100 </p>
            <p>A blanket/duvet at sh 400 and floor mat at sh.500 for 3*3M and sh.150 per extra 1M</p>
        </div>
        <form class="form-input" method="post" action="functions.php" enctype="multipart/form-data">
            <div class="input-field">
                <label>Date of submission for washing</label><br>
                <input type="date" name="sdate" placeholder="Select Date"><br><br>
            </div>
            <div class="selection">
                 <label>Type of cloth to be washed</label><br>
                <select name="ltype" name="ltype">
                    <option>Shirts</option>
                    <option>Sweaters</option>
                    <option>Blanket</option>
                    <option>Towel</option>
                    <option>Jacket</option>
                    <option>Floor Mat</option>
                </select><br><br></div>
            <div class="input-field">
                <label>Upload piccture of clothes to be washed</label><br>
                <input type="file" name="uploadfile" id="uploadfile">
            </div>
            <div class="input-field">
                <label>Expected date of picking</label><br>
                <input type="date" name="pdate" placeholder="Select Date"><br><br>
            </div>
            <!-- <div class="selection">
                <label>Status</label><br>
                <select type="selected" name="status">
                    <option>Work in progress</option>
                    <option>Ready</option>
                </Select>
            </div> -->
            <button type="submit" name="upload">Upload</button>
            <!-- <div class="selection">
                <label>Mode of Payment</label><br>
                <select>
                    <option>Cash</option>
                    <option>Mpesa</option>
                </Select>
            </div> -->
        </form>
    </div>
</div>
</body>
</html>