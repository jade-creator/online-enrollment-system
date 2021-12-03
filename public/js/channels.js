window.addEventListener('DOMContentLoaded', function() {
    Echo.private('pre-registration.'+studentId)
        .listen('StudentPreRegistered', (e) => {
            Livewire.emit('refresh-notification-component:'+userId);
            Livewire.emit('refresh-registration-index-component:'+userId);
            Livewire.emit('refresh-user-notification-component:'+userId);
        });

    Echo.private('notification-updated-count.'+userId)
        .listen('NotificationUpdatedCount', (e) => {
            Livewire.emit('refresh-notification-component:'+userId);
            Livewire.emit('refresh-user-notification-component:'+userId);
        });

    Echo.private('registration-status.'+studentId)
        .listen('RegistrationStatusUpdated', (e) => {
            Livewire.emit('refresh-notification-component:'+userId);
            Livewire.emit('refresh-user-notification-component:'+userId);
        });
});
