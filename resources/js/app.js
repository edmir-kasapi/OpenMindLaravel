import './admin/users';
import './admin/user-trash';
import './admin/products';
import './admin/products-trashed';
import './admin/admin-orders.js';
import './admin/admin-orders-trashed.js';
import './admin/admin-stores.js';
import './admin/admin-stores-trashed.js';
import './admin/admin-api-keys.js';
import './admin/admin-api-keys-revoked.js';
import './user/user-orders.js';
import './operator/stores.js';
import './operator/api-keys.js';
import './livewire/livewire-toasts.js';
import './livewire/livewire-actions.js';
import './operator/copy-key.js';
import ApexCharts from 'apexcharts';
import{
    showToast
} from './toasts.js';

window.ApexCharts = ApexCharts;
window.showToast = showToast; //showToast was definedh ere so that it can be used in blade views

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
