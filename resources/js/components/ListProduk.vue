<template>
  <div class="container" style="margin-top: 70px;">
    <sui-card-group :items-per-row="4">
      <sui-card>
        <sui-image :src="url"/>
        <sui-card-content extra>
          <p>Rp. 250.000</p>
        </sui-card-content>
      </sui-card>
      <sui-card>
        <sui-image :src="url"/>
        <sui-card-content extra>
          Rating: <sui-rating icon="star" :max-rating="4" :rating="4"/>
        </sui-card-content>
      </sui-card>
      <sui-card>
        <sui-image :src="url"/>
        <sui-card-content extra>
          Rating: <sui-rating icon="star" :max-rating="4" :rating="4"/>
        </sui-card-content>
      </sui-card>
      <sui-card>
        <sui-image :src="url"/>
        <sui-card-content extra>
          Rating: <sui-rating icon="star" :max-rating="4" :rating="4"/>
        </sui-card-content>
      </sui-card>
      <sui-card>
        <sui-image :src="url"/>
        <sui-card-content extra>
          Rating: <sui-rating icon="star" :max-rating="4" :rating="4"/>
        </sui-card-content>
      </sui-card>
      <sui-card>
        <sui-image :src="url"/>
        <sui-card-content extra>
          Rating: <sui-rating icon="star" :max-rating="4" :rating="4"/>
        </sui-card-content>
      </sui-card>
      <sui-card>
        <sui-image :src="url"/>
        <sui-card-content extra>
          Rating: <sui-rating icon="star" :max-rating="4" :rating="4"/>
        </sui-card-content>
      </sui-card>
    </sui-card-group>
  </div>
</template>

<script>
export default {
  name: 'ColumnCountCardExample',
  data: () => ({
      url : window.location.origin + window.location.pathname + 'images/nike.jpg'
  })
};
</script>
