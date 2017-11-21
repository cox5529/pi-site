function get_random_direction_most() {
	var directions = ['northernmost', 'southernmost', 'easternmost', 'westernmost', 'northwesternmost', 'northeasternmost', 'southeasternmost', 'southwesternmost', 'center-most'];
	return directions[Math.floor(Math.random() * directions.length)];
}

function get_random_direction_cardinal() {
	var directions = ['north', 'south', 'east', 'west'];
	return directions[Math.floor(Math.random() * directions.length)];
}

function get_random_resource() {
	var resources = ['wheat', 'rock', 'brick', 'wood', 'sheep'];
	return resources[Math.floor(Math.random() * resources.length)];
}

function get_random_catan_number() {
	var nums = [2, 3, 3, 4, 4, 4, 5, 5, 5, 5, 6, 6, 6, 6, 6, 8, 8, 8, 8, 8, 9, 9, 9, 9, 10, 10, 10, 11, 11, 12];
	return nums[Math.floor(Math.random() * nums.length)];
}

function replace_keys(str) {
	return str;
}

function replace_keys(str, username="") {
	str = str.replace("get_random_direction_most", get_random_direction_most());
	str = str.replace("get_random_direction_cardinal", get_random_direction_cardinal());
	str = str.replace("get_random_resource", get_random_resource());
	str = str.replace("get_random_catan_number", get_random_catan_number());
	str = str.replace("user_name", username);
	return str;
}
