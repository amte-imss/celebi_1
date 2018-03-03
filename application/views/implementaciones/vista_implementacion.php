<div class="content clearfix">
    <div class="wizard" id="content_detalle implementacion">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Información general del curso">
                        <span class="round-tab">
                            <i class="fas fa-bookmark fa-lg"></i>
                        </span>                                                                                                                                                                                                                                                </span>
                    </a>
                </li>
                <li role="presentation" class="disabled">
                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Programación">
                        <span class="round-tab">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </span>
                    </a>
                </li>
                <li role="presentation" class="disabled">
                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Profesores">
                        <span class="round-tab">
                            <i class="fas fa-users fa-lg"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="form">
            <div class="tab-content" id="content_wizard">
                <?php
                if (isset($etapas))
                {
                    echo $etapas;
                }
                ?>
            </div>
        </div>
    </div>
</div>
