/**
 * LocationSelector - Vanilla JS module for Country + Region dropdowns
 * Uses country-state-city npm package (no external API)
 *
 * Usage:
 *   import LocationSelector from './modules/LocationSelector';
 *
 *   // Init with saved values (for edit profile)
 *   LocationSelector.init('countrySelect', 'regionSelect', {
 *     savedCountry: 'IN',
 *     savedRegion: 'Gujarat',
 *   });
 *
 *   // Get selected values
 *   const country = LocationSelector.getCountry(); // e.g. 'IN'
 *   const region  = LocationSelector.getRegion();  // e.g. 'Gujarat'
 */

import { Country, State } from 'country-state-city';

class LocationSelector {
    constructor() {
        this.countrySelect = null;
        this.regionSelect = null;
        this.savedCountry = '';
        this.savedRegion = '';
        this._boundChangeHandlers = [];
    }

    /**
     * Initialise the country + region dropdowns
     * @param {string} countrySelectId - ID of the <select> element for countries
     * @param {string} regionSelectId - ID of the <select> element for regions
     * @param {Object} options - { savedCountry, savedRegion }
     */
    init(countrySelectId, regionSelectId, options = {}) {
        this.countrySelect = document.getElementById(countrySelectId);
        this.regionSelect = document.getElementById(regionSelectId);

        if (!this.countrySelect || !this.regionSelect) {
            console.warn('LocationSelector: select elements not found');
            return;
        }

        this.savedCountry = options.savedCountry || '';
        this.savedRegion  = options.savedRegion  || '';

        this._loadCountries();
        this._attachListeners();
    }

    /** Load all countries sorted alphabetically into the country dropdown */
    _loadCountries() {
        const countries = Country.getAllCountries();

        // Sort alphabetically by name
        countries.sort((a, b) => a.name.localeCompare(b.name));

        // Clear existing options (keep placeholder)
        this.countrySelect.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Select Country --';
        placeholder.disabled = true;
        placeholder.selected = true;
        this.countrySelect.appendChild(placeholder);

        countries.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.isoCode;        // ISO code as value (e.g. 'IN')
            opt.textContent = c.name;    // Full name as label (e.g. 'India')
            this.countrySelect.appendChild(opt);
        });

        // Pre-select saved country
        if (this.savedCountry) {
            this.countrySelect.value = this.savedCountry;
            this._onCountryChange(); // Load and pre-select region
        }
    }

    /** Attach change listeners */
    _attachListeners() {
        const onCountryChange = () => this._onCountryChange();
        this.countrySelect.addEventListener('change', onCountryChange);
        this._boundChangeHandlers.push({ el: this.countrySelect, fn: onCountryChange });
    }

    /** Handle country selection change */
    _onCountryChange() {
        const countryCode = this.countrySelect.value;

        if (!countryCode) {
            this._disableRegion('-- Select Region --');
            return;
        }

        this._loadRegions(countryCode);
    }

    /**
     * Load states/regions for the given country ISO code
     * @param {string} countryCode - ISO 3166-1 alpha-2 country code
     */
    _loadRegions(countryCode) {
        const states = State.getStatesOfCountry(countryCode);

        this.regionSelect.innerHTML = '';
        this.regionSelect.disabled = false;

        if (!states || states.length === 0) {
            this._disableRegion('No regions available');
            return;
        }

        // Sort alphabetically
        states.sort((a, b) => a.name.localeCompare(b.name));

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Select Region --';
        placeholder.disabled = true;
        placeholder.selected = true;
        this.regionSelect.appendChild(placeholder);

        states.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.name;           // State name as value
            opt.textContent = s.name;    // State name as label
            this.regionSelect.appendChild(opt);
        });

        // Pre-select saved region (match by name)
        if (this.savedRegion) {
            this.regionSelect.value = this.savedRegion;
        }
    }

    /** Disable region dropdown with a message */
    _disableRegion(message) {
        this.regionSelect.innerHTML = '';
        this.regionSelect.disabled = true;
        const opt = document.createElement('option');
        opt.value = '';
        opt.textContent = message;
        opt.disabled = true;
        opt.selected = true;
        this.regionSelect.appendChild(opt);
    }

    /** Get currently selected country ISO code */
    getCountry() {
        return this.countrySelect ? this.countrySelect.value : '';
    }

    /** Get currently selected region name */
    getRegion() {
        return this.regionSelect ? this.regionSelect.value : '';
    }

    /**
     * Reset both dropdowns to initial state
     */
    reset() {
        if (this.countrySelect) this.countrySelect.value = '';
        this._disableRegion('-- Select Region --');
        this.savedCountry = '';
        this.savedRegion  = '';
    }
}

// Export singleton instance
export default new LocationSelector();
