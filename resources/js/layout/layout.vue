<template>
  <div>
    <q-layout>
      <q-header class="bg-light-blue-8">
        <q-toolbar> 
            <q-btn @click="sidebar=!sidebar" flat icon="menu" class="shadow-5 bg-blue-9" rounded/>
            <q-toolbar-title>
                KASIR GACOR
            </q-toolbar-title>
            <q-space/>
            <div class="mr-4">
                Halo {{ user.role }}!
            </div>
            
        </q-toolbar>
      </q-header>
      <q-drawer v-model="sidebar" show-if-above:width="200" class="bg-light-blue-1 shadow-2">
        <q-list>
           <Link :href="'/'+user.role" as="q-item">
            <q-item clickable>
                <q-item-section side>
                    <q-icon name="grid_view"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>dashboard</q-item-label>
                </q-item-section>
            </q-item>
           </Link>
           
           <!-- ini tampilan ketika hanya admin yg bisa akses untuk admin -->
           <Link v-if="user.role=='admin'" href="/addUser" as="q-item">
            <q-item clickable>
                <q-item-section side>
                    <q-icon name="account_box"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>Petugas</q-item-label>
                </q-item-section>
            </q-item>
          </Link>

          <!-- Barang -->
           <Link  href="/barang" as="q-item">
            <q-item clickable>
                <q-item-section side>
                    <q-icon name="inventory"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>Barang</q-item-label>
                </q-item-section>
            </q-item>
          </Link>

            <!-- Pelanggan -->
          <Link  href="/pelanggan" as="q-item">
            <q-item clickable>
                <q-item-section side>
                    <q-icon name="group"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>Pelanggan</q-item-label>
                </q-item-section>
            </q-item>
          </Link>

          <!-- Penjualan -->
          <Link  href="/penjualan" as="q-item">
            <q-item clickable>
                <q-item-section side>
                    <q-icon name="shopping_cart"/>
                </q-item-section>
                <q-item-section>
                    <q-item-label>Penjualan</q-item-label>
                </q-item-section>
            </q-item>
          </Link>
        </q-list>

          <div class="">
              <Link href="/logout" as="q-btn">
                <q-btn label="Log Out" icon="logout" flat class="q-sl-sm "></q-btn>
              </Link>
            </div>
      </q-drawer>
      <q-page-container>
        <slot/>
      </q-page-container>
    </q-layout>
  </div>
</template>

<script>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue'
export default {
    setup() {
        const page = usePage();
        const user = computed(() => page.props.auth.user);
        const sidebar = ref(false);
        return {
            sidebar,
            user,
            sidebar
        };
    },
    components: { Link }
}
</script>

<style></style>