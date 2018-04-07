@extends('layouts.app')
@section('content')
<style type="text/css">
.role-action {
  height: 50px;
  line-height: 50px;
  background-color: rgba(208,208,208,0.5);
  font-size: 18px;
}
.role-search {
  margin: 30px;
  text-align: right;
}
li {
  list-style: none;
  line-height: 25px;
}
.inline-block {
  display: inline-block;
}
#tree {
  margin: 20px;
}
.tree-select {
  width: 13px;
  height: 13px;
  line-height: 16px;
  margin: 3px;
  display: inline-block;
  vertical-align: middle;
  border: 0 none;
  cursor: pointer;
  outline: none;
  background-color: transparent;
  background-repeat: no-repeat;
  background-attachment: scroll;
  background-image: url('{{ asset("img/2018/selects.png")  }}');
}
.tree-select-null {
  background-position: 0 0;
}
.tree-select-full {
  background-position: -14px 0;
}
.tree-select-half {
  background-position: -14px -28px;
}
.permit-title {
  height: 50px;
  background-color: #afacac;
  color: #ffffff;
  font-size: 20px;
  line-height: 50px;
  padding-left: 15px;
  margin-right: 90px;
  font-weight: 700;
  margin-bottom: 20px;
}
</style>


<div class="my-container">
  <div class="row">
    <div class="col-xs-12 role-action">
      {{ $role->name }}角色权限编辑
    </div>
  </div>

  <template id="one-select" style="display: none;">
    <ul>
      <li v-for="(node, key, index) in tree">
        <div v-if="key != 'selected'">
          <div v-on:click="nodeClick(node, index)" v-bind:class="[node.selected == null ? 'tree-select-null' : (node.selected == 'half' ? 'tree-select-half' : 'tree-select-full'), 'tree-select', 'inline-block']"></div>
          
          <div class="inline-block">@{{ key }}</div>
          <div v-if="key != ''">
            <one-select v-bind:tree="node" v-bind:isroot="false"></one-select>
          </div>
        </div>
      </li>
    </ul>
  </template>


  <div id="tree">
    <div class="col-xs-6">
      <div class="permit-title">
        功能权限
      </div>
      <one-select v-bind:isroot="true" v-bind:tree="tree"></one-select>
    </div>
    <div class="col-xs-6">
      <div class="permit-title">
        菜单权限
      </div>
      <one-select v-bind:isroot="true" v-bind:tree="menu_tree"></one-select>
    </div>
    <div class="col-xs-12" style="height: 15px;"></div>
    <button class="btn btn-success btn-lg col-xs-12" v-on:click="submit()">提交</button>
  </div>

</div>

<script>
var actionTree = new Object;
var menuTree = new Object;
Vue.component('one-select', {
  name: 'one-select',
  template: '#one-select',
  props: ['tree', 'isroot'],
  created: function() {
    if (this.isroot) {
      // actionTree = this.tree;
      // menuTree = this.tree;
    }
    var realTree = Object.assign({}, this.tree);
    delete realTree.selected;
    if (Object.keys(realTree).length === 0) {
      this.refreshAllParentNodes(this.$parent);
    }
  },
  methods: {
    nodeClick: function(node, index) {
      if (node.selected === 'full' || node.selected === 'half') {
        Vue.set(node, 'selected', null);
      } else {
        Vue.set(node, 'selected', 'full');
      }
      this.refreshAllParentNodes(this);
      this.refreshAllSonNodes(this.$children[index], node.selected);
    },
    refreshAllSonNodes: function(node, status) {
      if (node instanceof Vue && node.$children.length) {
        for (index in node.$children) {
          Vue.set(node.$children[index].tree, 'selected', status);
          // 递归计算子级
          this.refreshAllSonNodes(node.$children[index], status);
        }
      }
    },
    refreshAllParentNodes: function(node) {
      if (node instanceof Vue) {
        // console.log(node);
        var status = null;
        var nullCount = 0;
        var halfCount = 0;
        var fullCount = 0;
        for (index in node.$children) {
          if (typeof node.$children[index].tree.selected === 'undefined') {
            nullCount++;
          } else if (node.$children[index].tree.selected === null) {
            nullCount++;
          } else if (node.$children[index].tree.selected === 'half') {
            halfCount++;
          } else if (node.$children[index].tree.selected === 'full') {
            fullCount++;
          }
        }
        if (fullCount === node.$children.length) {
          status = 'full';
        } else if (nullCount === node.$children.length) {
          status = null;
        } else {
          status = 'half';
        }
        Vue.set(node.tree, 'selected', status);

        // 递归计算父级
        this.refreshAllParentNodes(node.$parent);
      }
    },
    log: function(o) {
      Fuck = o;
      console.log(o);
    }
  }
});
vm = new Vue({
  el: '#tree',
  data: {
    tree: JSON.parse('{!! json_encode($roleTreeArr, JSON_UNESCAPED_UNICODE) !!}'),
    menu_tree: JSON.parse('{!! json_encode($menuTreeArr, JSON_UNESCAPED_UNICODE) !!}')
  },
  methods: {
    submit: function() {
      // 功能权限为三级
      var actionTreeSelected = [];
      for (index0 in this.tree) {
        var cell0 = this.tree[index0];
        for (index1 in cell0) {
          var cell1 = cell0[index1];
          for (index2 in cell1) {
            var cell2 = cell1[index2];
            if (cell2 && cell2.selected === 'full') {
              actionTreeSelected.push(index0 + ',' + index1 + ',' + index2);
            }
          }
        }
      }

      // 菜单权限为二级
      var menuTreeSelected = [];
      for (index0 in this.menu_tree) {
        var cell0 = this.menu_tree[index0];
        for (index1 in cell0) {
          var cell1 = cell0[index1];
          for (index2 in cell1) {
            var cell2 = cell1[index2];
            if (cell2 && cell2.selected === 'full') {
              menuTreeSelected.push(index0 + ',' + index1 + ',' + index2);
            }
          }
        }
      }

      // var keys = JSON.stringify(actionTreeSelected);
      // console.log('数据权限：'+keys);
      // var keys = JSON.stringify(menuTreeSelected);
      // console.log('菜单权限：'+keys);
      // return false;
      $.ajax({
        url: '{{ url('/api/privilege/role/v1/permit/'.$role->id ) }}',
        method: 'post',
        dataType: 'json',  
        crossDomain: true, 
        data: {
          action_granteds : actionTreeSelected,
          menu_granteds : menuTreeSelected,
          _token: '{{ csrf_token() }}'
        },
        success: function(data) {
          console.log(data);
          if( data.status === 0 ) {
            swal( "修改成功！", "1秒后自动刷新", "success");
            window.setTimeout(function(){
              location.reload();
            },1000);
          } else {
            swal("提交出错，请刷新o(╯□╰)o", "", "error");
          }
        },
        error: function() {
          swal("提交出错，请刷新o(╯□╰)o", "", "error");
        }
      });
    }
  }
});
</script>

@endsection