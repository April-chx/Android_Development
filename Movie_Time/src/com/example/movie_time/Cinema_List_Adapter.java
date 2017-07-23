package com.example.movie_time;

import java.util.ArrayList;
import java.util.HashMap;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.View.OnClickListener;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

public class Cinema_List_Adapter extends BaseAdapter {
	
	private Context context;
	private ArrayList<HashMap<String, Object>> data;
	private String movie;
	private String time;
	private String movietype;
	private String url;
	/**
	 * LayoutInflater ���Ǵ���ʵ���л�ȡ�����ļ�����Ҫ��ʽ LayoutInflater layoutInflater =
	 * LayoutInflater.from(context); View convertView =
	 * layoutInflater.inflate();
	 * LayoutInflater��ʹ��,��ʵ�ʿ�����LayoutInflater����໹�Ƿǳ����õ�,�������������� findViewById(),
	 * ��ͬ����LayoutInflater��������layout��xml�����ļ�������ʵ������ ��findViewById()���Ҿ���xml�µľ���
	 * widget�ؼ�(��:Button,TextView��)��
	 */
	private LayoutInflater layoutInflater;
	
	public Cinema_List_Adapter(Context context, ArrayList<HashMap<String, Object>> data, String movie, String time, String movietype, String url) {

		this.context = context;
		this.data = data;
		this.movie = movie;
		this.time = time;
		this.movietype = movietype;
		this.url = url;
		this.layoutInflater = LayoutInflater.from(context);
	}

	/**
	 * ��ȡ����
	 */
	public int getCount() {
		return data.size();
	}

	/**
	 * ��ȡĳһλ�õ�����
	 */
	public Object getItem(int position) {
		return data.get(position);
	}

	/**
	 * ��ȡΨһ��ʶ
	 */
	public long getItemId(int position) {
		return position;
	}

	/**
	 * android����ÿһ�е�ʱ�򣬶�������������
	 */
	public View getView(final int position, View convertView, ViewGroup parent) {
		Cinema_List_Component component = null;
		if (convertView == null) {
			component = new Cinema_List_Component();
			// ��ȡ�������
			convertView = layoutInflater.inflate(R.layout.cinema_list_item, null);
			component.cinemaView = (TextView) convertView.findViewById(R.id.cinema);
			component.addressView = (TextView) convertView.findViewById(R.id.address);
			component.button = (Button) convertView.findViewById(R.id.button1);
			// ����Ҫע�⣬��ʹ�õ�tag���洢���ݵġ�
			convertView.setTag(component);
		} else {
			component = (Cinema_List_Component) convertView.getTag();
		}
		// �����ݡ��Լ��¼�����
		component.cinemaView.setText((String) data.get(position).get("cinema"));
		component.addressView.setText((String) data.get(position).get("address"));
		
		component.button.setOnClickListener(new OnClickListener() {
			public void onClick(View v) {
				Intent ci_intent = new Intent();
				ci_intent.setClass(context, Movie_Arrangement_Activity.class);
				
				Bundle ci_bundle = new Bundle();				
				ci_bundle.putString("movie", movie);
				ci_bundle.putString("time", time);
				ci_bundle.putString("movietype", movietype);
				ci_bundle.putString("url", url);
				ci_bundle.putString("cinema", (String)data.get(position).get("cinema"));
				ci_bundle.putString("address", (String)data.get(position).get("address"));
				ci_intent.putExtras(ci_bundle);
				
				context.startActivity(ci_intent);
			}

		});
		return convertView;
	}

	/**
	 * ���û������ťʱ�������¼����ᵯ��һ��ȷ�϶Ի���
	 */
//	public void showInfo() {
//
//		new AlertDialog.Builder(context)
//
//		.setTitle("�ҵ�listview")
//
//		.setMessage("����...")
//
//		.setPositiveButton("ȷ��", new DialogInterface.OnClickListener() {
//
//			public void onClick(DialogInterface dialog, int which) {
//
//			}
//
//		})
//
//		.show();
//
//	}

}