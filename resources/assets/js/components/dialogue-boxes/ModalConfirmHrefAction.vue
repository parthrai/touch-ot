<template>
  <span>

    <button
      :class=" this.buttonClass "
      v-on:click=" this.showModalConfirmHrefAction "
      :title=" this.buttonLabel "
    >
      {{ buttonLabel }}
    </button>

    <div
      v-bind:id=" this.modalId "
      class="modal fade modal-href-action"
      tabindex="-1"
      role="dialog"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Please confirm</h4>
          </div>
          <div class="modal-body">
            <div v-html=" this.messageHtml "></div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-default"
              data-dismiss="modal"
            >Cancel</button>
            <button
              type="button"
              class="btn btn-primary"
              v-on:click="doHrefAction"
            >{{ this.buttonLabel }}</button>
          </div>
        </div>
      </div>
    </div>

  </span>
</template>

<script>
  export default
  {
    props: [
      'modalId',
      'buttonLabel',
      'buttonClass',
      'actionHref',
      'messageHtml'
    ],
    data: function ()
    {
      return(
        {
        }
      );
    },
    methods: {
      showModalConfirmHrefAction: function ( event )
      {
        let vueInstance = this;
        console.log( "showModalConfirmHrefAction", vueInstance.modalId );
        $( "#" + vueInstance.modalId ).modal(
          {
            keyboard: false
          }
        );
      },
      doHrefAction: function ( event )
      {
        let vueInstance = this;
        console.log("doHrefAction", vueInstance.actionHref );
        document.location = vueInstance.actionHref;
      }
    },
    created: function ()
    {
      let vueInstance = this;
    },
    mounted: function ()
    {
      let vueInstance = this;
    }
  }
</script>

<style lang="scss" scoped>

  .modal-href-action
  {
    white-space:normal;
  }

</style>
