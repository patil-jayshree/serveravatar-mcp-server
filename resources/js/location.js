// Location Selector - dynamic import so it doesn't block page render
import('./modules/LocationSelector.js').then(module => {
    window.LocationSelector = module.default;
    // Dispatch event so profile blade knows LocationSelector is ready
    window.dispatchEvent(new Event('LocationSelectorReady'));
});
