<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="overview-wrap">
                    <h2 class="title-1">E'lonlar</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-40">
                    <table class="table table-white table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Foydalanuvchi</th>
                            <th scope="col">Mahsulot</th>
                            <th scope="col">Telefon raqam</th>
                            <th scope="col">Kanalga chiqarildi</th>
                            <th scope="col">Aktiv</th>
                            <th scope="col"></th>
                            <th scope="col">O'chirish</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($announces as $announce) { ?>
                        <tr>
                            <th scope="row"><?= $announce->id ?></th>
                            <td><?= $announce->owner ?></td>
                            <td><?= $announce->product ?></td>
                            <td><?= $announce->phone ?></td>
                            <td><?php if ($announce->published) {?>
                                    <i class="fas fa-check"></i>
                                <?php } else { ?>
                                    <i class="fas fa-pause"></i>
                                <?php } ?>
                            </td>
                            <td>
                                <input <?=($announce->status) ? 'checked' : ''?>
                                        data-id="<?=$announce->id?>"
                                        type="checkbox"
                                        data-onstyle="success"
                                        data-offstyle="danger"
                                        data-toggle="toggle"
                                        data-class="fast" />
                            </td>
                            <td><a role="button" href="<?= base_url('announce/edit/' . $announce->id) ?>"
                                   class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a></td>
                            <td><a role="button" href="<?= base_url('announce/delete/' . $announce->id) ?>"
                                   class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
                <div class="center">
                    <?= $pagination ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="copyright">
                    <p>Copyright © <?= date('Y') ?> Zuxriddin.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.status').change(function() {
        const data = {
            status: $(this).prop('checked'),
            id: $(this).attr('data-id')
        };
        $.ajax({
            method: "POST",
            url: "<?=base_url('announce/toggle_status')?>",
            data: data
        });
    })
</script>