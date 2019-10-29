
    <?php $title = $post['title'] ?>
    <?php ob_start(); ?>

        <p><a href="index.php">Retour à la liste des billets <?= $_SESSION['username'] ?></a></p>


        <div class="news">
            <h3>
            <em>Catégorie : <?= $post['name'] ?></em><br>
                <?= htmlspecialchars($post['title']) ?>
                <em>Par <?= $post['username'] ?></em>
            </h3>
            
            <p>
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </p>
            <img src="<?php echo $post['imagePath']?>" alt="illustration article">
        </div>

        <h2>Commentaires</h2>

        <form method="POST" action="index.php?action=addComment&amp;id=<?= $post['id'] ?>">
            <!-- <input type='text' id='author' name='author' placeholder='Auteur'> -->
            <input type='text' id='content' name='content' placeholder='Commentaire'>
            <input type='submit'>
        </form>

        <?php
        while ($comment = $comments->fetch())
        {
        ?>
        
                <strong><p><?= nl2br(htmlspecialchars($comment['author'])) ?></p></strong>
                <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
        <?php
        }
        $content = ob_get_clean();
        ?>

        <?php require('templateView.php') ?>