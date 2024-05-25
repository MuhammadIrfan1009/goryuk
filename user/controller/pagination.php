<!-- Pagination -->
<ul class="pagination pagination-sm">
                    <?php if ($halamanAktif > 1) : ?>
                        <li class="page-item prev">
                            <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">
                                <i class="tf-icon bx bx-chevrons-left"></i>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $jmlHalaman; $i++) : ?>
                        <?php if ($i == $halamanAktif) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php else : ?>
                            <li class="page-item">
                                <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($halamanAktif < $jmlHalaman) : ?>
                        <li class="page-item next">
                            <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">
                                <i class="tf-icon bx bx-chevrons-right"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!-- End Pagination -->