<?php $this->layout('layout', ['title' => 'Quiz']) ?>

<h2><?= $quizz->getTitle() ?></h2>
<h3><?= $quizz->getDescription() ?></h3>
<p><?= $author->getFirstName()?> <?= $author->getLastName()?></p>

<div class="row">
    <?php $index=-1 ?>
    <?php foreach ($questions as $currentQuestion) : ?>
    <?php $index++ ?>
        <div class="col-sm-4 mt-5">
            <div class="card border-0">
                <div class="card-body">
                    <button type="button" class="<?= $currentQuestion->levelsQuestions()->getColor()?> float-right"><?= $currentQuestion->levelsQuestions()->getName() ?></button>
                    <h3 class="card-title"><?= $currentQuestion->getQuestion() ?></h3>
                    <p class="card-author"><?= $mixResponce[$index][0]  ?> </p>
                    <p class="card-author"><?= $mixResponce[$index][1]  ?> </p>
                    <p class="card-author"><?= $mixResponce[$index][2]  ?> </p>
                    <p class="card-author"><?= $mixResponce[$index][3] ?> </p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
</div>
