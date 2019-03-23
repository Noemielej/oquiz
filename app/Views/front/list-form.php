<?php $this->layout('layout', ['title' => 'QuizCompte']) ?>

<h2><?= $quizz->getTitle() ?></h2>
<h3><?= $quizz->getDescription() ?></h3>
<p><?= $author->getFirstName()?> <?= $author->getLastName()?></p>

<div class="alert alert-primary" role="alert">
  <p> Nouveau jeu: répondez au maximum de questions avant de valider !</p>
</div>

<div class="row">
    <?php $index=-1 ?>
    <?php foreach ($questions as $currentQuestion) : ?>
        <?php $index++ ?>
        <div class="col-sm-4 mt-5">
            <div class="card border-0">
                <div class="card-body" data-id="<?= $currentQuestion->getId() ?>">
                    <button type="button" class="<?= $currentQuestion->levelsQuestions()->getColor()?> float-right"><?= $currentQuestion->levelsQuestions()->getName() ?></button>
                    <h3 class="card-title"><?= $currentQuestion->getQuestion() ?></h3>
                    <form action="<?= $router->generate('quizzes_ajaxquiz') ?>" method="post" id="formQuizz">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choice" id="exampleRadios1" value="option1">
                            <label class="form-check-label" for="exampleRadios1">
                                <?= $mixResponce[$index][0]  ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choice" id="exampleRadios2" value="option2">
                            <label class="form-check-label" for="exampleRadios2">
                                <?= $mixResponce[$index][1]  ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choice" id="exampleRadios3" value="option3">
                            <label class="form-check-label" for="exampleRadios3">
                                <?= $mixResponce[$index][2]  ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="choice" id="exampleRadios4" value="option4">
                            <label class="form-check-label" for="exampleRadios3">
                                <?= $mixResponce[$index][3]  ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="btn btn-primary btn-lg btn-block" id="buttonQuizz">ok</button>
</form>

<?php $this->push('js') ?>
<script src="<?= $basePath ?>/assets/js/app.js"></script>
<?php $this->end(); ?>
