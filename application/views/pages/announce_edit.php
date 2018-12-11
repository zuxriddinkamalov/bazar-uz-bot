<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form action="<?= base_url('announce/edit/' . $announce->id) ?>" method="POST">
                    <div class="card">
                        <div class="card-header">Tahrirlash</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="product" class="control-label mb-1">Maxsulot nomi</label>
                                <input id="product" name="product" type="text" class="form-control"
                                       aria-required="true" aria-invalid="false" value="<?= $announce->product ?>">
                            </div>
                            <div class="form-group">
                                <label for="price" class="control-label mb-1">Narxi</label>
                                <input id="price" name="price" type="text" class="form-control"
                                       value="<?= $announce->price ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone" class="control-label mb-1">Telefon raqam</label>
                                <input id="phone" name="phone" type="text" class="form-control"
                                       value="<?= $announce->phone ?>">
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label mb-1">Izoh</label>
                                <textarea id="description" name="description" rows="4"
                                          class="form-control"><?= $announce->description ?></textarea>
                            </div>
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-info">
                                    Saqlash
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                $message = $this->session->flashdata('message');
                if ($message) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $message ?>
                    </div>
                <?php } ?>
            </div>
        </div>


    </div>

</div>