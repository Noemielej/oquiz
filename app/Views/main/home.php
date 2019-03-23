<?php $this->layout('layout', ['title' => 'Home']) ?>

<h2>Bienvenue sur O'Quiz</h2>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis modi maxime iure voluptatum, dolorem commodi est nihil explicabo exercitationem! Consequuntur culpa libero maxime unde quidem eligendi molestiae ipsum voluptates quia, molestias mollitia maiores consequatur velit dolorum earum laboriosam sit ut, ullam aspernatur quod, asperiores eum a neque amet. Rerum porro voluptatibus exercitationem culpa expedita rem ipsam, consequuntur quisquam. Quidem exercitationem aspernatur fugit possimus nesciunt excepturi odio?</p>

<div class="row">
    <?php foreach ($quizzesList as $currentQuizzes) : ?>
        <div class="col-sm-4 mt-5">
                <div class="card border-0">
                    <div class="card-body">
                        <a href="<?= $router->generate('quizzes_quiz',['id' => $currentQuizzes->getId()]) ?>">
                            <h3 class="card-title">
                                <?= $currentQuizzes->getTitle() ?>
                            </h3>
                        </a>
                        <h4 class="card-text"><?= $currentQuizzes->getDescription() ?></h4>
                        <p class="card-author">
                            by <?=$currentQuizzes->getHost()->getFirstName()?> 
                            <?=$currentQuizzes->getHost()->getLastName()?> 
                        </p>
                    </div>
                </div>
        </div>
    <?php endforeach; ?>
</div>
