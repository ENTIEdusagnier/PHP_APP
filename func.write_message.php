<?php

function write_message ($message_info)
{
	$id_user = 0;

	if (isset($_SESSION["id_user"])){
		$id_user = intval($_SESSION["id_user"]);
	}

	$delete_link = "";

	if ($id_user == $message_info["id_user"]){
		$delete_link = <<<EOD
<p class="message-delete"><a href="message_delete.php?id_message={$message_info["id_message"]}">Eliminar</a></p>
EOD;
	}

	echo <<<EOD
<section class="message">
<h3><a href="profile.php?user={$message_info["username"]}">{$message_info["name"]}</a></h3>
<p class="message-text">{$message_info["message"]}</p>
<p class="message-date">{$message_info["post_time"]}</p>
{$delete_link}
</section>
EOD;
}


//Creo otra funcion para el dashboard menu el cual me permite hacer botones diferentes dependiendo el status.
function write_message_dashboard ($message_info)
{
	$id_user = 0;

	if (isset($_SESSION["id_user"])){
		$id_user = intval($_SESSION["id_user"]);
	}

	$delete_link = 1; //Esta disponible y se puede borrar
	$recover_link = 0; //Esta borrado y podemos recuperar el mensaje
	$edit_link = 2; // Esta en modo borrador
	
	$button_link = "";
	$status = "";
	//Si el mensaje esta activo saldra el boton de eliminar
	if ($message_info["status"] == $delete_link){
		$button_link .= <<<EOD
<p class="message-delete"><a href="message_delete.php?id_message={$message_info["id_message"]}">Eliminar</a></p>
EOD;
		$button_link .= <<<EOD
<p class="message-delete"><a href="message_draft.php?id_message={$message_info["id_message"]}">Draft</a></p>
EOD;
		$status = <<<EOD
<p class="message-status"><strong>Mensaje Posteado</strong></p>
EOD;
	}
	//Si el mensaje esta eliminado saldra el boton de recuperar
	if ($message_info["status"] == $recover_link){
		$button_link .= <<<EOD
<p class="message-recover"><a href="message_recover.php?id_message={$message_info["id_message"]}">Recuperar</a></p>
EOD;
		$status = <<<EOD
<p class="message-status"><strong>Mensaje Eliminado</strong></p>
EOD;
	}
	//En este if si el mensaje esta en status de Draft o publico sacara un boton de editar
	if ($message_info["status"] == $edit_link || $message_info["status"] == $delete_link){
		$button_link .= <<<EOD
<p class="message_edit"><a href="message_edit.php?id_message={$message_info["id_message"]}">Editar</a></p>
EOD;
	}

	if ($message_info["status"] == $edit_link){
		$status = <<<EOD
<p class="message-status"><strong>Mensaje en Draft</strong></p>
EOD;
	}
	
	echo <<<EOD
<section class="message">
<h3><a href="profile.php?user={$message_info["username"]}">{$message_info["name"]}</a></h3>
<p class="message-text">{$message_info["message"]}</p>
<p class="message-date">{$message_info["post_time"]}</p>
{$status}
{$button_link}
</section>
EOD;
}
?>
