<template x-for="(group, gIndex) in section.items" :key="gIndex">
    <template>
        <!-- Judul Bidang -->
        <tr class="bg-red-100 dark:bg-red-900 text-gray-900 dark:text-white font-semibold">
            <td class="px-6 py-3" x-text="group.judul" colspan="4"></td>
        </tr>

        <!-- Rincian Sub Bidang -->
        <template x-for="item in group.children" :key="item.id_rincian">
            <tr
                class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/60 transition">
                <td class="px-6 py-4" x-text="item.judul"></td>
                <td class="px-6 py-4 text-right" x-text="formatRupiah(item.anggaran)"></td>
                <td class="px-6 py-4 text-right" x-text="formatRupiah(item.realisasi)"></td>
                <td class="px-6 py-4 text-right"
                    :class="(item.anggaran - item.realisasi) < 0 ? 'text-red-600 dark:text-red-400' : ''"
                    x-text="formatRupiah(item.anggaran - item.realisasi)"></td>
            </tr>
        </template>
    </template>
</template>
