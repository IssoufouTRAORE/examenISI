<?php

define("HOST", "localhost"); 			// The host you want to connect to.
define("USER", "root"); 			// The database username.
define("PASSWORD", ""); 	// The database password.
define("DATABASE", "markaz");             // The database name.


define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "user");

/**
 * Is this a secure connection?  The default is FALSE, but the use of an
 * HTTPS connection for logging in is recommended.
 *
 * If you are using an HTTPS connection, change this to TRUE
 */
define("SECURE", FALSE);    // For development purposes only!!!!
$pdo_option[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$mysqli = new PDO('mysql:host=localhost;dbname=markaz', 'root', '', $pdo_option);
$mysqli->exec('SET NAMES utf8');
$link = mysql_connect("localhost","roo");
mysql_query("SET CHARACTER SET 'utf8';", $link) or die(mysql_error());
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="../style.css" />
		<link rel="stylesheet" href="../css/style.css" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<script src="../js/jquery.min.js"></script>
		<script src="../js/recAudio.js"></script>
		<title></title>
	</head>
	<body>
		<div id="container">
			<h1>Mon compte</h1>
			<?php
				$selectEleve = $mysqli->query("SELECT nom, prenom, sexe, dateNais, lieuNais, nvoEtude, profession, residence, numeroTel, grpwhatsApp, matricule FROM eleves WHERE matricule = '".$_SESSION['matricule']."'");
				//$resultatEleve = $selectEleve->fetch();
				$eleve = $selectEleve->fetch();
			?>
			
			<div id="presentation eleve pour compo">
				<div id="info eleve pour compo">
					<p>
						<span class="libelle-ar"><span>
						<span class="libelle-fr"><span>
						<span class="renseignement"><?php echo $eleve['nom']." ".$eleve['prenom'];?><span>
					</p>
				</div>
			</div>
			<div id="row">
				<div id="matiere">
					<h2 class="titreMatiere">أصول الفقه</h2>
					<div id="question">
						<center>
							<audio controls src="../audios/questions/1.mp3">
							</audio>
						</center>
					</div>
					<div id="boutonReponse">
						<!--<form method="POST" action="" enctype="multipart/form-data">
							<button id="startRecordingButton" class="btn btn-primary btn-xs" title="Commencer l'enregistrement">
								Commencer
							</button>
							<button id="stopRecordingButton" class="btn btn-info btn-xs" title="Arrêter l'enregistrement">
								Arrêter
							</button>
							<button id="playButton">Play</button>
							<button id="downloadButton">Download</button>
							<script src="../js/recAudio.js"></script>
						</form>-->
						<h1>Audio</h1>

    <button id="startRecordingButton">Start recording</button>
    <button id="stopRecordingButton">Stop recording</button>
    <button id="playButton">Play</button>
    <button id="downloadButton">Download</button>

    <script>
        var startRecordingButton = document.getElementById("startRecordingButton");
        var stopRecordingButton = document.getElementById("stopRecordingButton");
        var playButton = document.getElementById("playButton");
        var downloadButton = document.getElementById("downloadButton");


        var leftchannel = [];
        var rightchannel = [];
        var recorder = null;
        var recordingLength = 0;
        var volume = null;
        var mediaStream = null;
        var sampleRate = 44100;
        var context = null;
        var blob = null;

        startRecordingButton.addEventListener("click", function () {
            // Initialize recorder
            navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
            navigator.getUserMedia(
            {
                audio: true
            },
            function (e) {
                console.log("user consent");

                // creates the audio context
                window.AudioContext = window.AudioContext || window.webkitAudioContext;
                context = new AudioContext();

                // creates an audio node from the microphone incoming stream
                mediaStream = context.createMediaStreamSource(e);

                // https://developer.mozilla.org/en-US/docs/Web/API/AudioContext/createScriptProcessor
                // bufferSize: the onaudioprocess event is called when the buffer is full
                var bufferSize = 2048;
                var numberOfInputChannels = 2;
                var numberOfOutputChannels = 2;
                if (context.createScriptProcessor) {
                    recorder = context.createScriptProcessor(bufferSize, numberOfInputChannels, numberOfOutputChannels);
                } else {
                    recorder = context.createJavaScriptNode(bufferSize, numberOfInputChannels, numberOfOutputChannels);
                }

                recorder.onaudioprocess = function (e) {
                    leftchannel.push(new Float32Array(e.inputBuffer.getChannelData(0)));
                    rightchannel.push(new Float32Array(e.inputBuffer.getChannelData(1)));
                    recordingLength += bufferSize;
                }

                // we connect the recorder
                mediaStream.connect(recorder);
                recorder.connect(context.destination);
            },
                        function (e) {
                            console.error(e);
                        });
        });

        stopRecordingButton.addEventListener("click", function () {

            // stop recording
            recorder.disconnect(context.destination);
            mediaStream.disconnect(recorder);

            // we flat the left and right channels down
            // Float32Array[] => Float32Array
            var leftBuffer = flattenArray(leftchannel, recordingLength);
            var rightBuffer = flattenArray(rightchannel, recordingLength);
            // we interleave both channels together
            // [left[0],right[0],left[1],right[1],...]
            var interleaved = interleave(leftBuffer, rightBuffer);

            // we create our wav file
            var buffer = new ArrayBuffer(44 + interleaved.length * 2);
            var view = new DataView(buffer);

            // RIFF chunk descriptor
            writeUTFBytes(view, 0, 'RIFF');
            view.setUint32(4, 44 + interleaved.length * 2, true);
            writeUTFBytes(view, 8, 'WAVE');
            // FMT sub-chunk
            writeUTFBytes(view, 12, 'fmt ');
            view.setUint32(16, 16, true); // chunkSize
            view.setUint16(20, 1, true); // wFormatTag
            view.setUint16(22, 2, true); // wChannels: stereo (2 channels)
            view.setUint32(24, sampleRate, true); // dwSamplesPerSec
            view.setUint32(28, sampleRate * 4, true); // dwAvgBytesPerSec
            view.setUint16(32, 4, true); // wBlockAlign
            view.setUint16(34, 16, true); // wBitsPerSample
            // data sub-chunk
            writeUTFBytes(view, 36, 'data');
            view.setUint32(40, interleaved.length * 2, true);

            // write the PCM samples
            var index = 44;
            var volume = 1;
            for (var i = 0; i < interleaved.length; i++) {
                view.setInt16(index, interleaved[i] * (0x7FFF * volume), true);
                index += 2;
            }

            // our final blob
            blob = new Blob([view], { type: 'audio/wav' });
        });

        playButton.addEventListener("click", function () {
            if (blob == null) {
                return;
            }

            var url = window.URL.createObjectURL(blob);
            var audio = new Audio(url);
			//document.write(url); blob:null/0dd37468-b3b2-4580-ad44-48068ff889b9
            audio.play();
        });

        downloadButton.addEventListener("click", function () {
            if (blob == null) {
                return;
            }

            var url = URL.createObjectURL(blob);

            var a = document.createElement("a");
            document.body.appendChild(a);
            a.style = "display: none";
            a.href = url;
            a.download = "sample.wav";
            a.click();
            window.URL.revokeObjectURL(url);
        });

        function flattenArray(channelBuffer, recordingLength) {
            var result = new Float32Array(recordingLength);
            var offset = 0;
            for (var i = 0; i < channelBuffer.length; i++) {
                var buffer = channelBuffer[i];
                result.set(buffer, offset);
                offset += buffer.length;
            }
            return result;
        }

        function interleave(leftChannel, rightChannel) {
            var length = leftChannel.length + rightChannel.length;
            var result = new Float32Array(length);

            var inputIndex = 0;

            for (var index = 0; index < length;) {
                result[index++] = leftChannel[inputIndex];
                result[index++] = rightChannel[inputIndex];
                inputIndex++;
            }
            return result;
        }

        function writeUTFBytes(view, offset, string) {
            for (var i = 0; i < string.length; i++) {
                view.setUint8(offset + i, string.charCodeAt(i));
            }
        }

    </script>
					</div>
					
					<?php
						/*if(!file_exists("photos-des-chauffeurs/"))
						mkdir("photos-des-chauffeurs/");
						else{
							$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
							//1. strrchr renvoie l'extension avec le point (« . »).
							//2. substr(chaine,1) ignore le premier caractère de chaine.
							//3. strtolower met l'extension en minuscules.
							$extension_upload = strtolower(substr(  strrchr($_FILES['icone']['name'], '.') ,1) );
							if( in_array($extension_upload,$extensions_valides) ) echo "Extension correcte";
							
							$photo = $nom."-".$prenom."-".$telephone;
							$nomPhoto = "photos-des-chauffeurs/".$photo.$extension_upload;
							$resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $nomPhoto);
							if ($resultat){	
								$requete = $mysqli->query("INSERT INTO chauffeur(nomChauffeur, pnomChauffeur, dateEmbauche, contactChauffeur, dateSave, dateUpdate) VALUES ('".$nom."', '".$prenom."', '".$dateEmb."', '".$telephone."', '".$dateSave."', '".$dateUpdate."')");
								header("location:add.php");
							}
						}*/
					?>
				</div>
			</div>
			
			<div id="matiere">
				<h2></h2>
				<div id="info eleve pour compo">
					
				</div>
			</div>
			
			<form action="" method="post">
				<p>
					<input type="submit" name="envoyerCompo" value="   Valider mes réponses   " />
				</p>
			</form>
			
			<?php
				if(isset($_POST['commencerCompo'])){
					header("location:compo.php");
				}
			?>
			
		</div>
	</body>
</html>