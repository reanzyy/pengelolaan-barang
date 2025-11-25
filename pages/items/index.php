<?php
// logic yang berada di folder app
require('./../../app/user.php');

// breadcrumnd
$title = "Daftar Barang";
$items = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Barang', 'url' => '../items/index.php'],
    ['label' => 'Daftar', 'url' => '']
];

// button
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
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Berat</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1;
                            $items = query("SELECT * FROM items");
                            ?>

                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item->name ?></td>
                                    <td><?= $item->category ?></td>
                                    <td><?= $item->weight ?></td>
                                    <td class="text-end">
                                        <div class="d-flex gap-1">
                                            <a class="btn btn-sm btn-warning"
                                                href="edit.php?id=<?= $item->id ?>">
                                                <i class="bx bx-edit-alt"></i>Ubah
                                            </a>    
                                            <button type="button"
                                                data-action="delete.php?id=<?= $item->id ?>"
                                                data-confirm-text="Anda yakin menghapus data barang ini?"
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