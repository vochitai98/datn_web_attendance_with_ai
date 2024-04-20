from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/upload', methods=['POST'])
def upload():
    # Kiểm tra xem request có chứa dữ liệu không
    if 'username' not in request.form or 'image' not in request.files:
        return jsonify({'error': 'Thiếu thông tin username hoặc ảnh'}), 400

    username = request.form['username']
    image = request.files['image']

    # Xử lý ảnh, ví dụ: lưu vào thư mục hoặc thực hiện các thao tác khác

    # Trả về phản hồi thành công
    return jsonify({'message': 'Upload ảnh thành công', 'username': username}), 200

if __name__ == '__main__':
    app.run(debug=True)