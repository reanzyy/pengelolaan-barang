<?php
require('./../../app/function/function.php');

$title = "Daftar Pengirim";
$items = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Pengirim', 'url' => '../senders/index.php'],
    ['label' => 'Daftar', 'url' => '']
];

$action_buttons = [
    ['icon' => '<i class="bx bx-plus"></i>', 'text' => 'Tambah Data', 'url' => 'create.php', 'class' => 'btn-primary'],
];

include('./../../views/layouts/main-header.php');
?>

<div class="card">
    <div class="d-flex align-items-end row">
        <div class="col-sm-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datatable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Phone</th>
                                <th>Kota</th>
                                <th>Alamat</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1;
                            $senders = query("SELECT * FROM senders");
                            ?>

                            <?php foreach ($senders as $sender) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $sender->name ?></td>
                                    <td><?= $sender->phone ?></td>
                                    <td><?= $sender->city ?></td>
                                    <td><?= $sender->address ?></td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1">
                                            <a class="btn btn-sm btn-warning"
                                                href="edit.php?id=<?= $sender->id ?>">
                                                <i class="bx bx-edit-alt"></i>Ubah
                                            </a>
                                            <button type="button"
                                                data-action="delete.php?id=<?= $sender->id ?>"
                                                data-confirm-text="Anda yakin menghapus data Pengirim ini?"
                                                class="btn btn-sm btn-danger btn-delete">
                                                <i class="bx bx-trash"></i>Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('./../../views/layouts/main-footer.php') ?>