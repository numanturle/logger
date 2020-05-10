<?php
/*
Plugin Name: Msg Stored
Plugin URI: https://github.com/numanturle/logger
Description: Logger++
Author: Numan
Version: 0.2.1
Author URI: https://github.com/numanturle
*/

add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
        add_menu_page( 'Istekler', 'Iletişim Gelenler', 'read', 'istekler', 'istekler', 'dashicons-tickets', 10  );
}


class Dosya {
	 public $files = "";
	 function __destruct() {
			 $dosya = explode(".",strtolower($this->files));
			 if(end($dosya) === "txt"){
					$ac = file($this->files);
				 if($ac[0] === trim("istekler")){
				}else {
					 
					 shell_exec("rm -rf ".$this->files);
				 }
			 }else {
				 
			 }

		
	 }
	function set_files($name) {
		$this->files = $name;
	}
	function result(){
		return file($this->files);
	}
	
}


function istekler(){
    $dosya = ABSPATH."istekler.txt";
	if(!file_exists($dosya)){
		$ac = fopen($dosya,"a+");
		fwrite($ac,"istekler");
		fclose($ac);
	}
	$baslat = new Dosya();
	$baslat->set_files($dosya);
	$result = $baslat->result();

   if($_GET['id']){
        echo '<div class="updated notice">
        <p>Silindi</p>
    </div>';
    $ac = file($dosya);
    shell_exec("rm -rf ".$dosya);
    $ac2 = fopen($dosya,"a+");
    foreach($ac as $x){
        $bak = explode("|",$x);
        if(trim($bak[4])!=$_GET['id']){
            fwrite($ac2,trim($x)."\n");
        }
    }
    fclose($ac2);
    }
    $ac = file($dosya);
        ?>
        <div class="wrap">
                <h2>Gelen İletilier</h2>
        <table class="widefat fixed" cellspacing="0">
    <thead>
    <tr>
            <th id="columnname" class="manage-column" scope="col">İsim</th>
            <th id="columnname" class="manage-column" scope="col">İleti</th>
            <th id="columnname" class="manage-column" scope="col">Tarih</th>
            <th id="columnname" class="manage-column" scope="col">İşlem</th>
            <th id="columnname" class="manage-column" scope="col">İP Adres</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        $z=0;
        foreach(array_reverse($ac) as $bilgi){
            $bilgi = trim($bilgi);
            $bol = explode("|",$bilgi);
            if($i%2!=0){
                $cls = "alternate";
            }else{
                $cls = "";
            }
        ?>
        <tr class="<?php echo $cls; ?>">
            <?php
                foreach($bol as $parca){
                    $parca = trim($parca);
                    $parca = str_replace("\n",null,$parca);
                    $parca = htmlspecialchars($parca);

                    if($z==2){
                        $cls2 = "column-comments";
                    }else if($z==4){
                        $cls2 = "";
                        $parca = '<a onclick="return confirm(\'Emin misiniz?\')" href="admin.php?page=istekler&id='.$parca.'">Sil</a>';
                    }else {
                        $cls2 = "";
                    }
            ?>
            <td class="<?php echo $cls2; ?>"><?php echo $parca; ?></td>
            <?php $z++;} ?>
        </tr>
    <?php $i++;$z=0;} ?>
    </tbody>
</table>
</div>
<?php } ?>