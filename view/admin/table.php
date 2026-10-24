<?php if (empty($rows)): ?><p>Belum ada data pengaduan.</p><?php else: ?>
<table><thead><tr><th>ID</th><th>NIS</th><th>Kategori</th><th>Lokasi</th><th>Keterangan</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?php echo e($r['id_aspirasi']); ?></td><td><?php echo e($r['nis']); ?></td><td><?php echo e($r['ket_kategori']); ?></td><td><?php echo e($r['lokasi']); ?></td><td><?php echo e($r['ket']); ?></td><td><span class="badge"><?php echo e($r['status']); ?></span></td><td><a class="btn-small" href="index.php?page=<?php echo isset($_SESSION['role']) && $_SESSION['role']==='admin'?'admin':'siswa'; ?>&action=detail&id=<?php echo e($r['id_aspirasi']); ?>">Detail</a></td></tr><?php endforeach; ?>
</tbody></table><?php endif; ?>
