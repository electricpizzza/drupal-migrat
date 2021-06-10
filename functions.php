<?php


function getData($filename)
{
    $data = file_get_contents($filename);
    return json_decode($data);
}

function insertNode($row, $conn)
{

    $title = html_entity_decode(htmlspecialchars($row->title));
    // echo  $row->nid . "<br> " . $row->vid . "<br> " . $row->type . "<br> " . $row->uuid . "<br> " . $row->vuuid;
    $sql = "INSERT INTO `node`(`nid`, `vid`, `type`, `uuid`, `langcode`) 
    VALUES ('$row->nid','$row->vid','$row->type','$row->uuid','$row->language')";
    $conn->exec($sql);
    echo "node <br>";

    $body = $row->body;
    if ($body == null)
        $body = $row->field_body;
    $body = $body->und[0];

    $html = html_entity_decode($body->value);

    $sql = $conn->prepare("INSERT INTO `node__body`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `body_value`, `body_summary`, `body_format`) 
    VALUES ('$row->type','0','$row->nid','$row->revision_uid','$row->language',0,:html,'$body->summary','basic_html')");
    $sql->bindParam('html', $html);
    $sql->execute();
    echo "node__body <br>";


    $sql = "INSERT INTO `node__comment`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `comment_status`)
     VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$row->comment')";
    $conn->exec($sql);
    echo "node__comment <br>";



    $sql = $conn->prepare("INSERT INTO `node_field_data`(`nid`, `vid`, `type`, `langcode`, `status`, `uid`, `title`, `created`, `changed`, `promote`, `sticky`, `default_langcode`, `revision_translation_affected`)
    VALUES ('$row->nid','$row->vid','$row->type','$row->language','$row->status','$row->uid',:title,'$row->created','$row->changed','$row->promote','$row->sticky',1,1)");
    $sql->bindParam('title', $title);
    $sql->execute();

    // $conn->exec($sql);
    echo "node_field_data <br>";


    $sql = $conn->prepare("INSERT INTO `node_field_revision`(`nid`, `vid`, `langcode`, `status`, `uid`, `title`, `created`, `changed`, `promote`, `sticky`, `default_langcode`, `revision_translation_affected`)
         VALUES ('$row->nid','$row->vid','$row->language','$row->status','$row->uid',:title,'$row->created','$row->changed','$row->promote','$row->sticky',1,1)");
    $sql->bindParam('title', $title);
    $sql->execute();
    echo "node_field_revision <br>";


    $sql = "INSERT INTO `node_revision`(`nid`, `vid`, `langcode`, `revision_uid`, `revision_timestamp`, `revision_log`, `revision_default`)
     VALUES ('$row->nid','$row->vid','$row->language','$row->revision_uid','$row->revision_timestamp',null, 1)";
    $conn->exec($sql);
    echo "node_revision <br>";

    $sql = $conn->prepare("INSERT INTO  `node_revision__body`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `body_value`, `body_summary`, `body_format`)
    VALUES ('$row->type','0','$row->nid','$row->revision_uid','$row->language',0,:html,'$body->summary','basic_html')");
    $sql->bindParam('html', $html);
    $sql->execute();
    echo "node_revision__body <br>";


    $sql = "INSERT INTO `node_revision__comment`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `comment_status`) 
       VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$row->comment')";
    $conn->exec($sql);
    echo "node_revision__comment <br>";
}

function addActu($conn)
{

    $data = getData('content.json');
    $index = 0;
    foreach ($data as $row) {
        $index++;
        insertNode($row, $conn);
        $img = $row->field_image->und[0];

        $sql = "INSERT INTO `file_managed`(`fid`, `uuid`, `langcode`, `uid`, `filename`, `uri`, `filemime`, `filesize`, `status`, `created`, `changed`)
         VALUES ('$img->fid','$img->uuid','fr','$img->uid','$img->filename','$img->uri','$img->filemime','$img->filesize','$img->status','$img->timestamp','$img->timestamp')";
        $conn->exec($sql);
        echo "file_managed <br>";
        $sql = "SELECT COUNT(*) FROM `file_managed`";
        $result = $conn->prepare($sql);
        $result->execute();
        $fid = $result->fetchColumn();

        $sql = "INSERT INTO `file_usage`(`fid`, `module`, `type`, `id`, `count`)
         VALUES ('$fid','file','node','$row->nid',1)";
        $conn->exec($sql);
        echo "file_usage <br>";

        $sql = "INSERT INTO `node__field_image`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `field_image_target_id`, `field_image_alt`, `field_image_title`, `field_image_width`, `field_image_height`) 
        VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$fid','$img->alt','$img->title','$img->width','$img->height')";
        $conn->exec($sql);
        echo "node__field_image <br>";




        $sql = "INSERT INTO `node_revision__field_image`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `field_image_target_id`, `field_image_alt`, `field_image_title`, `field_image_width`, `field_image_height`) 
            VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$img->fid','$img->alt','$img->title','$img->width','$img->height')";
        $conn->exec($sql);
        echo "node_revision__field_image <br>";



        echo $row->uuid . " is inserted <br>";
        echo "New record created successfully  <br>";
    }


    echo "<h1>$index New records created successfully </h1> <br>";
}

function addRecM($conn)
{

    $data = getData('content.json');
    $index = 0;
    foreach ($data as $row) {
        $index++;
        insertNode($row, $conn);
        echo $row->uuid . " is inserted <br>";
        echo "New record created successfully  <br>";
    }


    echo "<h1>$index New records created successfully </h1> <br>";
}


function addAgenda($conn)
{

    $data = getData('content.json');
    $index = 0;
    foreach ($data as $row) {
        $index++;
        insertNode($row, $conn);
        echo $row->uuid . " is inserted <br>";
        echo "New record created successfully  <br>";

        $tid = $row->field_categorie->und[0]->tid;
        $sql = "INSERT INTO `node__field_categorie`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `field_categorie_target_id`)
         VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$tid')";
        $conn->exec($sql);
        echo "node__field_categorie <br>";

        $day = $row->field_day->und[0]->value;
        $sql = "INSERT INTO `node__field_jour`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `field_jour_value`)
         VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$day')";
        $conn->exec($sql);
        echo "node__field_jour <br>";


        $mois = $row->field_month->und[0]->value;
        $sql = "INSERT INTO `node__field_mois`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `field_mois_value`)
          VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$mois')";
        $conn->exec($sql);
        echo "node__field_mois <br>";

        $add = $row->field_event_addresse->und[0]->value;
        $sql = "INSERT INTO `node__field_event_addresse`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `field_event_addresse_value`)
          VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$add')";
        $conn->exec($sql);
        echo "node__field_event_addresse <br>";

        $city = $row->field_city->und[0]->value;
        $sql = "INSERT INTO `node__field_ville`(`bundle`, `deleted`, `entity_id`, `revision_id`, `langcode`, `delta`, `field_ville_value`)
          VALUES ('$row->type',0,'$row->nid','$row->revision_uid','$row->language',0,'$city')";
        $conn->exec($sql);
        echo "node__field_ville <br>";
    }


    echo "<h1>$index New records created successfully </h1> <br>";
}
