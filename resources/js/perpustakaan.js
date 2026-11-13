// resources/js/perpustakaan.js
// Perilaku Alpine.js untuk komponen UI. Import di resources/js/app.js:
//   import Alpine from 'alpinejs'
//   import focus from '@alpinejs/focus'      // dipakai x-trap di <x-ui.modal>
//   import './perpustakaan'
//   Alpine.plugin(focus)
//   window.Alpine = Alpine
//   Alpine.start()

document.addEventListener('alpine:init', () => {
  /** <x-ui.combobox>: ketik untuk mencari, pilih dengan klik atau keyboard. */
  window.Alpine.data('uiCombobox', ({ options, value, placeholder }) => ({
    options,
    value,
    placeholder,
    open: false,
    query: '',
    active: 0,

    get selected() {
      return this.options.find((o) => o.value == this.value)
    },
    get selectedText() {
      return this.selected ? [this.selected.label, this.selected.meta].filter(Boolean).join(' · ') : ''
    },
    get filtered() {
      const normalize = (s) => s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '')
      const words = normalize(this.query).split(/\s+/).filter(Boolean)
      if (!words.length) return this.options
      return this.options.filter((o) => {
        const haystack = normalize(`${o.label} ${o.meta ?? ''} ${o.keywords ?? ''}`)
        return words.every((w) => haystack.includes(w))
      })
    },

    openList() {
      if (this.open || this.$el.querySelector('[role=combobox]').disabled) return
      this.open = true
      this.query = ''
      const i = this.options.findIndex((o) => o.value == this.value)
      this.active = i >= 0 ? i : 0
    },
    close() {
      this.open = false
      this.query = ''
    },
    search(text) {
      this.query = text
      this.active = 0
      this.open = true
    },
    move(delta) {
      if (!this.open) return this.openList()
      const n = this.filtered.length
      this.active = n ? (this.active + delta + n) % n : 0
      this.$nextTick(() => this.$el.querySelector('.ui-combobox__option--active')?.scrollIntoView({ block: 'nearest' }))
    },
    pick(option) {
      this.value = option.value
      this.close()
      this.$dispatch('change', option.value)
    },
    choose() {
      if (this.open && this.filtered[this.active]) this.pick(this.filtered[this.active])
    },
  }))
})
