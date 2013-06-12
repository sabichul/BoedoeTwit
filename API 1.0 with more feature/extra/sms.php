<?php 

menu_register(array( 


   'sms' => array(
      'hidden'   => true,
      'security' => true,
      'callback' => 'sms_page',
   ),
)); 


function sms_page($query){
    $content = "<div class='well container'>";

    $content .= '<form method="post" enctype="multipart-form-data" name="my_form" action="http://www.sms-online.web.id/kirim">

  <input type="hidden" name="teks" value="">
  <input class="field text small" type="text" maxlength="20" name="Phonenumbers" placeholder="Nomor (0812xxx/02173xxx)">
  <br>

  <textarea rows="4" cols="20" name="Text" id="Text" placeholder="Isi silakan gunakan hanya huruf normal (alphabet) dalam pesan. Huruf mengandung kode yang tidak normal akan otomatis dihapus."></textarea>
<br>

<input id="saveForm" class="btTxt" type="submit" value="KIRIM" name="TOMBOL">

 <span id="remaining">160</span> huruf lagi<br>
	<div class="entry_footer">

	</div>
	</form>';

    $content .= "</div>";

    $content .= js_counter('Text');

    theme('page', "Free SMS", $content);
}  

?>