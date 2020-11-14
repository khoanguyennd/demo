import React, { Component } from 'react';
import { ActivityIndicator, FlatList, Text, View } from 'react-native';

import { StyleSheet, ScrollView } from 'react-native';
import { Table, TableWrapper, Row } from 'react-native-table-component';
import { DataTable } from 'react-native-paper';

export default class NewsPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      movies: [],
      data: [],
      isLoading: true
    };

    this.state = {
      tableHead: ['ID', 'Title', 'releaseYear'],
      widthArr: [40, 60, 80]
    }

  }

  componentDidMount() {
    fetch('https://reactnative.dev/movies.json')
      .then((response) => response.json())
      .then((json) => {

//        json.movies.map((userData) => {
//            //console.log('mother', userData);
//            //this.setState({ movies: userData });
//        });
        this.setState({ data: json.movies });
      })
      .catch((error) => console.error(error))
      .finally(() => {
        this.setState({ isLoading: false });
      });
  }

  render() {
    const {movies, data, isLoading } = this.state;

    const state = this.state;
     const tableData = [];

//        for (let i = 0; i < 5; i += 1) {
//          const rowData = [];
//          for (let j = 0; j < 9; j += 1) {
//            rowData.push(`${i}${j}`);
//          }
//          tableData.push(rowData);
//        }

        //console.log(tableData);

//          for (let moviesObject of data) {
//              console.log(moviesObject);
//          }
//     const data1 = data;
//      data = (item) => {
//
//         console.log(item);
//
//      }


    //tableData.push(movies);
//let movies3 = [
//  {
//    id: "bd7acbea-c1b1-46c2-aed5-3ad53abb28ba",
//    title: "First Item",
//  },
//  {
//    id: "3ac68afc-c605-48d3-a4f8-fbd91aa97f63",
//    title: "Second Item",
//  },
//  {
//    id: "58694a0f-3da1-471f-bd96-145571e29d72",
//    title: "Third Item",
//  },
//];
    //tableData.push(movies2);

    //console.log('object', movies2);

    let movies2 = data;
// console.log('noka', movies2);
// console.log('noka1', data);
 if (data) {
      for (let moviesObject of movies2) {
          //console.log('he', moviesObject.id);
          const rowData = [];
          rowData.push(moviesObject.id);
          rowData.push(moviesObject.title);
          rowData.push(moviesObject.releaseYear);
          tableData.push(rowData);
      }
 }

//          movies2 = (item) => {
//             console.log('hello')
//             console.log(item);
//
//          }
//

    return (
        <View style={styles.container}>
          <ScrollView horizontal={true}>
            <View style={{ flex: 1, paddingTop: 10 }}>
                <DataTable>
                    <DataTable.Header>
                      <DataTable.Title>ID</DataTable.Title>
                      <DataTable.Title>Title</DataTable.Title>
                      <DataTable.Title>releaseYear</DataTable.Title>
                    </DataTable.Header>
                  {isLoading ? <ActivityIndicator/> : (
                    <FlatList
                      data={data}
                      keyExtractor={({ id }, index) => id}
                      renderItem={({ item, index }) => (

                        <ScrollView style={styles.dataWrapper}>
                            <DataTable.Row>
                              <DataTable.Cell>{item.id}</DataTable.Cell>
                              <DataTable.Cell>{item.title}</DataTable.Cell>
                              <DataTable.Cell>{item.releaseYear}</DataTable.Cell>
                            </DataTable.Row>
                         </ScrollView>
                      )}
                    />
                  )}

                </DataTable>
            </View>
          </ScrollView>
              <View style={{ flex: 1, paddingTop: 10 }}>

                    <ScrollView style={styles.dataWrapper}>
                      <Table borderStyle={{borderWidth: 1, borderColor: '#C1C0B9'}}>
                        {

                          tableData.map((rowData, index) => (
                            <Row
                              key={index}
                              data={rowData}
                              widthArr={state.widthArr}
                              style={[styles.row, index%2 && {backgroundColor: '#F7F6E7'}]}
                              textStyle={styles.text}
                            />
                          ))
                        }
                      </Table>
                    </ScrollView>
               </View>
        </View>

    );
  }

};

 const styles = StyleSheet.create({
  container: { flex: 1, padding: 16, paddingTop: 30, backgroundColor: '#fff' },
  header: { height: 50, backgroundColor: '#537791' },
  text: { textAlign: 'center', fontWeight: '100' },
  dataWrapper: { marginTop: -1 },
  row: { height: 40, backgroundColor: '#E7E6E1' }
});



//import React, { Component } from 'react';
//import { StyleSheet, View, ScrollView } from 'react-native';
//import { Table, TableWrapper, Row } from 'react-native-table-component';
//
//export default class NewsPage extends Component {
//  constructor(props) {
//    super(props);
//    this.state = {
//      tableHead: ['Head', 'Head2', 'Head3', 'Head4', 'Head5', 'Head6', 'Head7', 'Head8', 'Head9'],
//      widthArr: [40, 60, 80, 100, 120, 140, 160, 180, 200]
//    }
//
//    this.movies = [];
//
//  }
//
//  render() {
//
//        const getMoviesFromApiAsync = async () => {
//          try {
//            let response = await fetch(
//              'https://reactnative.dev/movies.json'
//            );
//            let json = await response.json();
//            console.log('hello motherzo');
//            console.log(json.movies);
//            console.log('hello motherzo1');
//            return json.movies;
//          } catch (error) {
//            console.error(error);
//          }
//        };
//
//const movies1 = getMoviesFromApiAsync();
//console.log('hi ', movies1);
//
//    const state = this.state;
//    const tableData = [];
//
//    for (let i = 0; i < 30; i += 1) {
//      const rowData = [];
//      for (let j = 0; j < 9; j += 1) {
//        rowData.push(`${i}${j}`);
//      }
//      tableData.push(rowData);
//    }
//
//    return (
//      <View style={styles.container}>
//        <ScrollView horizontal={true}>
//          <View>
//            <Table borderStyle={{borderWidth: 1, borderColor: '#C1C0B9'}}>
//              <Row data={state.tableHead} widthArr={state.widthArr} style={styles.header} textStyle={styles.text}/>
//            </Table>
//            <ScrollView style={styles.dataWrapper}>
//              <Table borderStyle={{borderWidth: 1, borderColor: '#C1C0B9'}}>
//                {
//                  tableData.map((rowData, index) => (
//                    <Row
//                      key={index}
//                      data={rowData}
//                      widthArr={state.widthArr}
//                      style={[styles.row, index%2 && {backgroundColor: '#F7F6E7'}]}
//                      textStyle={styles.text}
//                    />
//                  ))
//                }
//              </Table>
//            </ScrollView>
//          </View>
//        </ScrollView>
//      </View>
//    )
//  }
//}
//
//const styles = StyleSheet.create({
//  container: { flex: 1, padding: 16, paddingTop: 30, backgroundColor: '#fff' },
//  header: { height: 50, backgroundColor: '#537791' },
//  text: { textAlign: 'center', fontWeight: '100' },
//  dataWrapper: { marginTop: -1 },
//  row: { height: 40, backgroundColor: '#E7E6E1' }
//});








//import React, { Component } from 'react';
//import { View, Text, StyleSheet } from 'react-native';
//import { Header } from 'react-native-elements';
//import { Left, Right, Icon } from 'native-base';
//
//
//class NewsPage extends Component {
//    static navigationOptions = {
//        drawerIcon: ({ tintColor }) => (
//            <Icon name="list" style={{ fontSize: 24, color: tintColor }} />
//        )
//    }
//
//    render() {
//        return (
//            <View style={styles.container}>
//                <Header
//                    leftComponent={<Icon name="menu" onPress={() => this.props.navigation.openDrawer()} />}
//                />
//                <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
//                    <Text>News Page</Text>
//                </View>
//            </View>
//        );
//    }
//}
//
//const styles = StyleSheet.create({
//    container: {
//        flex: 1
//    }
//});
//
//export default NewsPage;
